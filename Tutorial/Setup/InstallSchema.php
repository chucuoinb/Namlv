<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08/07/2017
 * Time: 08:55
 */

namespace Namlv\Tutorial\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        // TODO: Implement install() method.
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('namlv_tutorial_post')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('namlv_tutorial_post')
            )
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true
                    ],
                    'POST ID'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false,
                    ],
                    'POST TITLE'
                )
                ->addColumn(
                    'observer',
                    Table::TYPE_TEXT,
                    null,
                    [],
                    'POST observer'
                )
                ->addColumn(
                    'description',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false,
                    ],
                    'POST DESCRIPTION'
                )
                ->addColumn(
                    'image',
                    Table::TYPE_TEXT,
                    null,
                    [
                        'nullable' => false,
                    ],
                    'POST IMAGE'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' => false,
                        'default' => '1',
                    ],
                    'POST STATUS'
                )
                ->addColumn(
                    'create_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],

                    'TIME CREATE'
                )
                ->addColumn(
                    'update_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],

                    'TIME UPDATE'
                )
                ->setComment('POST TABLE');
            $installer->getConnection()->createTable($table);
            $installer->getConnection()->addIndex(
                $installer->getTable('namlv_tutorial_post'),
                $setup->getIdxName(
                    $installer->getTable('namlv_tutorial_post'),
                    ['title', 'description', 'image'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['title', 'description', 'image'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        if (!$installer->tableExists('namlv_tutorial_post_store')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('namlv_tutorial_post_store')
            )
                ->addColumn(
                    'post_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'unsigned' => true],
                    'namlv_tutorial_post.id'
                )
                ->addColumn(
                    'store_id',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false,'unsigned' => true],
                    'store.store_id'
                )->addIndex(
                    $installer->getIdxName('namlv_tutorial_post_store', ['store_id']),
                    ['store_id']
                )->addForeignKey(
                    $installer->getFkName('namlv_tutorial_post_store', 'post_id', 'namlv_tutorial_post', 'id'),
                    'post_id',
                    $installer->getTable('namlv_tutorial_post'),
                    'id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )->addForeignKey(
                    $installer->getFkName('namlv_tutorial_post_store', 'store_id', 'store', 'store_id'),
                    'store_id',
                    $installer->getTable('store'),
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )->setComment(
                    'Post Store To Store Linkage Table'
                );
            $installer->getConnection()->createTable($table);

        }
        $installer->endSetup();
    }
}
