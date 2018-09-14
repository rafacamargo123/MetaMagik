<?php

namespace Kanboard\Plugin\MetaMagik\Filter;

use Kanboard\Core\Filter\FilterInterface;
use Kanboard\Model\MetadataModel;
use Kanboard\Model\TaskModel;
use Kanboard\Model\TaskMetadataModel;
use PicoDb\Database;

/**
 * Class Metadata Value Filter
 *
 */
class MetaValueFilter extends BaseFilter implements FilterInterface
{
    /**
     * Database object
     *
     * @access private
     * @var Database
     */
    private $db;

    /**
     * Get search attribute
     *
     * @access public
     * @return string[]
     */
    public function getAttributes()
    {
        return array('metaval');
    }

    /**
     * Set database object
     *
     * @access public
     * @param  Database $db
     * @return $this
     */
    public function setDatabase(Database $db)
    {
        $this->db = $db;
        return $this;
    }

    /**
     * Apply filter
     *
     * @access public
     * @return FilterInterface
     */
    public function apply()
    {
        $metafield = $this->db
            ->hashtable($this->'task_has_metadata')
            ->eq('value', $this->value)
            ->asc('task_id')
            ->getAll('task_id');
            
        $task_ids = $metafield;

        $this->query->in(TaskModel::TABLE.'.id', $task_ids);

        return $this;
    }
}
