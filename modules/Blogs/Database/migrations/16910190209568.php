<?php
namespace Blogs\Database;

use Vendimia\Database\Migration\{Schema,Action};
use Vendimia\Database\FieldType;

use Blogs\Model;

/**
 * Migration created 2023-08-02 18:30:20.
 *
 * Methods should be prefixed with "blogs_"
 */
return new class {
    #[Action\Create]
    public function blogs_post(Schema $schema)
    {
        $schema->field('id', FieldType::AutoIncrement);
        $schema->field('blog_id', FieldType::ForeignKey);
        $schema->field('identificador', FieldType::Char, length: 512);
        $schema->field('identificador_hashed', FieldType::FixChar, length: 64);
        $schema->field('fecha_publicación', FieldType::DateTime);
        $schema->field('fecha_modificación', FieldType::DateTime);
        $schema->field('título', FieldType::Char, length: 128, null: true);
        $schema->field('cuerpo', FieldType::Text);
        $schema->field('url_imagen', FieldType::Char, length: 512, null: true, default: null);
        $schema->field('permalink', FieldType::Char, length: 512, null: true, default: null);

        $schema->primaryKey('id');
        $schema->index('identificador_hashed');
    }
    /**/
};
