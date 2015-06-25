<?php

namespace Oro\Bundle\EmailBundle\Migrations\Schema\v1_12;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\OrderedMigrationInterface;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class RemoveOldSchema implements Migration, OrderedMigrationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritDoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        self::removeOldSchema($schema);
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public static function removeOldSchema(Schema $schema)
    {
        self::removeOldRelations($schema);
        self::updateEmailUserTableFields($schema);
    }

    protected static function removeOldRelations(Schema $schema)
    {
        $emailBodyTable = $schema->getTable('oro_email_body');

        if ($emailBodyTable->hasForeignKey('fk_oro_email_body_email_id')) {
            $emailBodyTable->removeForeignKey('fk_oro_email_body_email_id');
        }
        if ($emailBodyTable->hasIndex('IDX_C7CE120DA832C1C9')) {
            $emailBodyTable->dropIndex('IDX_C7CE120DA832C1C9');
        }
        if ($emailBodyTable->hasColumn('email_id')) {
            $emailBodyTable->dropColumn('email_id');
        }
    }

    protected static function updateEmailUserTableFields(Schema $schema)
    {
        $emailUserTable = $schema->getTable('oro_email_user');

        $emailUserTable->changeColumn('folder_id', ['notnull' => true]);
        $emailUserTable->changeColumn('email_id', ['notnull' => true]);
    }
}
