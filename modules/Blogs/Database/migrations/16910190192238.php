<?php
namespace Blogs\Database;

use Vendimia\Database\Migration\{Schema,Action};
use Vendimia\Database\FieldType;

use Blogs\Model;

/**
 * Migration created 2023-08-02 18:30:19.
 *
 * Methods should be prefixed with "blogs_"
 */
return new class {
    #[Action\Create]
    public function blogs_blog(Schema $schema)
    {
        $schema->field('id', FieldType::AutoIncrement);
        $schema->field('usuario_id', FieldType::ForeignKey);
        $schema->field('nombre', FieldType::Char, length: 128);
        $schema->field('descripción', FieldType::Char, length: 128, after: 'nombre');
        $schema->field('url', FieldType::Char, length: 256);
        $schema->field('hash_url', FieldType::Char, length: 64);
        $schema->field('url_feed', FieldType::Char, length: 256);
        $schema->field('url_ícono', FieldType::Char, length: 256, null: true);
        $schema->field('tipo_feed', FieldType::Enum, values: ['json-feed']);
        $schema->field('activo', FieldType::Boolean, default: true);

        $schema->primaryKey('id');
    }
    /**/
};