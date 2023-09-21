<?php
namespace Usuarios\Database;

use Vendimia\Database\Migration\{Schema,Action};
use Vendimia\Database\FieldType;

use Usuarios\Model;

/**
 * Migration created 2023-08-02 18:27:50.
 *
 * Methods should be prefixed with "usuarios_"
 */
return new class {
    #[Action\Create]
    public function usuarios_usuario(Schema $schema)
    {
        $schema->field('id', FieldType::AutoIncrement);
        $schema->field('usuario', FieldType::Char, length: 32);
        $schema->field('nombre', FieldType::Char, length: 128);
        $schema->field('hash', FieldType::Char, length: 32);

        $schema->primaryKey('id');
        $schema->uniqueIndex('usuario');
    }
};