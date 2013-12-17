<?php

namespace Models\Generics;
use Models\Interfaces\IBaseManager;
use Doctrine\DBAL\Connection;

abstract class BaseManager implements IBaseManager
{    
    /**
     * _properties
     * @var array
     */
    private $_properties;

    /**
     * DBAL connector
     * 
     * @var \Doctrine\DBAL\Connection
     */
    protected $connexion;

    /**
    * Nom de la table dans la base données
    * @var string
    */
    protected $_table;

    /**
     * Constructor
     * 
     * @param \Doctrine\DBAL\Connection $connexion
     */
    public function __construct(Connection $connexion)
    {
        $this->connexion = $connexion;
    }

    /**
     * Initialise une transaction
     */
    public function beginTransaction() {

        $this->connexion->beginTransaction();
    }

    /**
     * Commit une transaction
     */
    public function commit() {

        $this->connexion->commit();
    }

    /**
     * Rollback d'une transaction
     */
    public function rollback() {

        $this->connexion->rollback();
    }

    /**
     * Separate values and primary key
     * 
     * @param  array    $data 
     * @param  array    $primary
     * 
     * @return array    Array with 2 keys (primary, values).
     */
    public function keysValues($primary, $data) {

        return array(
            'primary' => array_intersect_key($data, $primary),
            'values'  => array_diff_key($data, $primary),
        );
    }

    /**
     * Save 
     * 
     * @param  EntityInterface $object
     * @param boolean   Indique si l'on force la valeur de la clé primaire ou si l'on délégue la tache à la base de données
     */
    public function save(EntityInterface $object)
    {
        // TODO: Gérer les transaction
        $keysValues = $this->keysValues($this->_primary, $this->_bindValues($object));
        $element = $this->select($keysValues['primary']);

        if (empty($element)) 
            $element = new $this->_entity();

        if ($element->isNew())
            $this->insert($object);
        else
            $this->update($object);
    }

    /**
     * Select one raw in database
     * 
     * @param  array  $key key of search
     * 
     * @return array
     */
    public function select($keys = array(), $forceArray = false)
    {
        $sql = '';

        foreach ($keys as $key => $value) {
            
            $sql .= (empty($sql) ? ' WHERE ' : ' AND ') . $key . ' = ?';
        }

        $sql = 'SELECT * FROM '. $this->_table . $sql;
        
        if ($forceArray === true)
            return $this->connexion->fetchAssoc($sql, array_values($keys));
        else
            return $this->getObject($this->connexion->fetchAssoc($sql, array_values($keys)));
    }

    /**
     * Select all raw in database
     * 
     * @param  array  $constraints
     * 
     * @return array
     */
    public function findOne($constraints = array(), $column = '')
    {
        $sql = '';

        foreach ($constraints as $key => $value) {
            
            $sql .= (empty($sql) ? ' WHERE ' : ' AND ') . $key . ' = ?';
        }

        $sql = 'SELECT ' . $column . ' FROM ' . $this->_table . $sql;

        return $this->connexion->fetchColumn($sql, array_values($constraints));
    }

    /**
     * Select all raw in database
     * 
     * @param  array  $constraints
     * 
     * @return array
     */
    public function find($constraints = array(), $forceArray = false)
    {
        $sql = '';

        foreach ($constraints as $key => $value) {
            
            $sql .= (empty($sql) ? ' WHERE ' : ' AND ') . $key . ' = ?';
        }

        $sql = 'SELECT * FROM ' . $this->_table . $sql;

        if ($forceArray === true)
            return $this->connexion->fetchAll($sql, array_values($constraints));
        else
            return $this->getListObject($this->connexion->fetchAll($sql, array_values($constraints)));
    }

    /**
     * Retour un EntityInterface depuis le résultat d'une requête SQL
     * 
     * @param  array  $rdata
     * 
     * @return EntityInterface
     */
    public function getObject($rdata = array())
    {
        $bind = array_flip($this->getBinding());

        $data = array();

        if (is_array($rdata)){

            foreach ($rdata as $key => $value) {

                if (array_key_exists($key, $bind))
                    $data[$bind[$key]] = $value;
            }
        }

        return new $this->_entity($data);
    }

    /**
     * Retourne un tableau de EntityInterface depuis une requête SQL
     * 
     * @param  array  $result
     * 
     * @return array
     */
    public function getListObject($result = array())
    {
        $objects = array();

        if (is_array($result)) {

            foreach ($result as $value) {
                
                $objects[] = $this->getObject($value);
            }
        }

        return $objects;
    }

    /**
     * Insert in database from entity
     * 
     * @param EntityInterface or array
     * @param boolean   Indique si l'on force la valeur de la clé primaire ou si l'on délégue la tache à la base de données
     */
    public function insert($object)
    {
        if (is_array($object))
            return $this->connexion->insert($this->_table, $object);
        
        if($object instanceof EntityInterface) {

            $data = $this->_bindValues($object);
            
            return $this->connexion->insert($this->_table, $data);
        }

        return 0;
    }

    /**
     * Update in database
     * 
     * @param EntityInterface
     */
    public function update(EntityInterface $object)
    {
        $bound = $this->_bindValues($object);

        $keysValues = $this->keysValues($this->_primary, $bound);

        return $this->connexion->update($this->_table, $keysValues['values'], $keysValues['primary']);
    }

    /**
     * Supprimer dans la base de données
     * 
     * @param EntityInterface
     */
    public function delete($contrainte = array())
    {
        return $this->connexion->delete($this->_table, $contrainte);
    }

     /**
     * Count all raw in database
     * 
     * @param  array  $constraints
     * 
     * @return array
     */
    public function count($constraints = array())
    {
        $sql = '';

        foreach ($constraints as $key => $value) {
            
            $sql .= (empty($sql) ? ' WHERE ' : ' AND ') . $key . ' = ?';
        }

        $sql = 'SELECT COUNT(*) FROM ' . $this->_table . $sql;

        return $this->connexion->fetchColumn($sql, array_values($constraints));
    }

    /**
     * Return an array where key bind with column database
     * 
     * @param  EntityInterface $object
     * @return array
     */
    private function _bindValues(EntityInterface $object)
    {
        $data = $object->toArray();
        $bind = array_flip($this->getBinding());

        foreach ($bind as $key => $value) {
            
            $bind[$key] = $data[$value];
        }

        return $bind;
    }
}