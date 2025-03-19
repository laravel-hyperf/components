<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Testing\Concerns;

use Hyperf\Collection\Arr;
use Hyperf\Contract\Jsonable;
use Hyperf\Database\ConnectionInterface;
use Hyperf\Database\Events\QueryExecuted;
use Hyperf\Database\Model\Model;
use Hyperf\Database\Model\SoftDeletes;
use Hyperf\Database\Query\Expression;
use LaravelHyperf\Foundation\Testing\Constraints\CountInDatabase;
use LaravelHyperf\Foundation\Testing\Constraints\HasInDatabase;
use LaravelHyperf\Foundation\Testing\Constraints\NotSoftDeletedInDatabase;
use LaravelHyperf\Foundation\Testing\Constraints\SoftDeletedInDatabase;
use LaravelHyperf\Support\Facades\DB;
use PHPUnit\Framework\Constraint\LogicalNot as ReverseConstraint;

trait InteractsWithDatabase
{
    /**
     * Assert that a given where condition exists in the database.
     */
    protected function assertDatabaseHas(Model|string $table, array $data, ?string $connection = null): static
    {
        $this->assertThat(
            $this->getTable($table),
            new HasInDatabase($this->getConnection($connection, $table), $data)
        );

        return $this;
    }

    /**
     * Assert that a given where condition does not exist in the database.
     */
    protected function assertDatabaseMissing(Model|string $table, array $data, ?string $connection = null): static
    {
        $constraint = new ReverseConstraint(
            new HasInDatabase($this->getConnection($connection, $table), $data)
        );

        $this->assertThat($this->getTable($table), $constraint);

        return $this;
    }

    /**
     * Assert the count of table entries.
     */
    protected function assertDatabaseCount(Model|string $table, int $count, ?string $connection = null): static
    {
        $this->assertThat(
            $this->getTable($table),
            new CountInDatabase($this->getConnection($connection, $table), $count)
        );

        return $this;
    }

    /**
     * Assert that the given table has no entries.
     */
    protected function assertDatabaseEmpty(Model|string $table, ?string $connection = null): static
    {
        $this->assertThat(
            $this->getTable($table),
            new CountInDatabase($this->getConnection($connection, $table), 0)
        );

        return $this;
    }

    /**
     * Assert the given record has been "soft deleted".
     */
    protected function assertSoftDeleted(Model|string $table, array $data = [], ?string $connection = null, string $deletedAtColumn = 'deleted_at'): static
    {
        if ($this->isSoftDeletableModel($table)) {
            return $this->assertSoftDeleted(
                $table->getTable(),
                array_merge($data, [$table->getKeyName() => $table->getKey()]),
                $table->getConnectionName(),
                $table->getDeletedAtColumn()
            );
        }

        $this->assertThat(
            $this->getTable($table),
            new SoftDeletedInDatabase(
                $this->getConnection($connection, $table),
                $data,
                $this->getDeletedAtColumn($table, $deletedAtColumn)
            )
        );

        return $this;
    }

    /**
     * Assert the given record has not been "soft deleted".
     */
    protected function assertNotSoftDeleted(Model|string $table, array $data = [], ?string $connection = null, string $deletedAtColumn = 'deleted_at'): static
    {
        if ($this->isSoftDeletableModel($table)) {
            return $this->assertNotSoftDeleted(
                $table->getTable(),
                array_merge($data, [$table->getKeyName() => $table->getKey()]),
                $table->getConnectionName(),
                $table->getDeletedAtColumn()
            );
        }

        $this->assertThat(
            $this->getTable($table),
            new NotSoftDeletedInDatabase(
                $this->getConnection($connection, $table),
                $data,
                $this->getDeletedAtColumn($table, $deletedAtColumn)
            )
        );

        return $this;
    }

    /**
     * Assert the given model exists in the database.
     */
    protected function assertModelExists(Model $model): static
    {
        return $this->assertDatabaseHas(
            $model->getTable(),
            [$model->getKeyName() => $model->getKey()],
            $model->getConnectionName()
        );
    }

    /**
     * Assert the given model does not exist in the database.
     */
    protected function assertModelMissing(Model $model): static
    {
        return $this->assertDatabaseMissing(
            $model->getTable(),
            [$model->getKeyName() => $model->getKey()],
            $model->getConnectionName()
        );
    }

    /**
     * Specify the number of database queries that should occur throughout the test.
     */
    public function expectsDatabaseQueryCount(int $expected, ?string $connection = null): static
    {
        with($this->getConnection($connection), function ($connectionInstance) use ($expected, $connection) {
            $actual = 0;

            $connectionInstance->listen(function (QueryExecuted $event) use (&$actual, $connectionInstance, $connection) {
                if (is_null($connection) || $connectionInstance === $event->connection) {
                    ++$actual;
                }
            });

            $this->beforeApplicationDestroyed(function () use (&$actual, $expected, $connectionInstance) {
                $this->assertSame(
                    $actual,
                    $expected,
                    "Expected {$expected} database queries on the [{$connectionInstance->getName()}] connection. {$actual} occurred."
                );
            });
        });

        return $this;
    }

    /**
     * Determine if the argument is a soft deletable model.
     */
    protected function isSoftDeletableModel(mixed $model): bool
    {
        return $model instanceof Model
            && in_array(SoftDeletes::class, class_uses_recursive($model));
    }

    /**
     * Cast a JSON string to a database compatible type.
     */
    public function castAsJson(array|object|string $value): Expression
    {
        if ($value instanceof Jsonable) {
            $value = $value->toJson();
        } elseif (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        $value = DB::connection()->getPdo()->quote($value);

        return DB::raw(
            DB::connection()->getQueryGrammar()->compileJsonValueCast($value)
        );
    }

    /**
     * Get the database connection.
     */
    protected function getConnection(?string $connection = null, ?string $table = null): ConnectionInterface
    {
        return DB::connection($connection);
    }

    /**
     * Get the table name from the given model or string.
     */
    protected function getTable(Model|string $table): string
    {
        return $this->newModelFor($table)?->getTable() ?: $table;
    }

    /**
     * Get the table connection specified in the given model.
     */
    protected function getTableConnection(Model|string $table): ?string
    {
        return $this->newModelFor($table)?->getConnectionName();
    }

    /**
     * Get the table column name used for soft deletes.
     */
    protected function getDeletedAtColumn(string $table, string $defaultColumnName = 'deleted_at'): string
    {
        return $this->newModelFor($table)?->getDeletedAtColumn() ?: $defaultColumnName;
    }

    /**
     * Get the model entity from the given model or string.
     */
    protected function newModelFor(Model|string $table): ?Model
    {
        return is_subclass_of($table, Model::class) ? (new $table()) : null;
    }

    /**
     * Seed a given database connection.
     */
    public function seed(array|string $class = 'Database\Seeders\DatabaseSeeder'): static
    {
        foreach (Arr::wrap($class) as $class) {
            $this->artisan('db:seed', ['--class' => $class, '--no-interaction' => true]);
        }

        return $this;
    }
}
