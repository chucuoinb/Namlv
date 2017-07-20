<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08/07/2017
 * Time: 08:55
 */
namespace Namlv\Tutorial\Setup;
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
        if(!$installer->tableExists('namlv_tutorial_post')){
            $table = $installer->getConnection()->newTable(
                $installer->getTable('namlv_tutorial_post')
            )
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity'=>true,
                        'nullable'=>false,
                        'primary'=>true,
                        'unsigned'=>true,
                    ],
                    'POST ID'
                )
                ->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    [
                        'nullable'=>false,
                    ],
                    'POST TITLE'
                )
                ->addColumn(
                    'observer',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    [],
                    'POST observer'
                )
                ->addColumn(
                    'description',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    [
                        'nullable'=>false,
                    ],
                    'POST DESCRIPTION'
                )
                ->addColumn(
                    'image',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    40,
                    [
                        'nullable'=>false,
                    ],
                    'POST IMAGE'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable'=>false,
                        'default' => '1',
                    ],
                    'POST STATUS'
                )
                ->addColumn(
                    'create_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],

                    'TIME CREATE'
                )
                ->addColumn(
                    'update_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],

                    'TIME UPDATE'
                )
                ->setComment('POST TABLE');
            $installer->getConnection()->createTable($table);
            $installer->getConnection()->addIndex(
                $installer->getTable('namlv_tutorial_post'),
                $setup->getIdxName(
                    $installer->getTable('namlv_tutorial_post'),
                    ['title','description','image'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['title','description','image'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
            $installer->endSetup();
        }
    }
}
