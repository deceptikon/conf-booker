<?php

namespace ConfBooker\Map;

use ConfBooker\User;
use ConfBooker\UserQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'users' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UserTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'ConfBooker.Map.UserTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'conf_booker_db';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'users';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ConfBooker\\User';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ConfBooker.User';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'users.id';

    /**
     * the column name for the fullname field
     */
    const COL_FULLNAME = 'users.fullname';

    /**
     * the column name for the reg_date field
     */
    const COL_REG_DATE = 'users.reg_date';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'users.email';

    /**
     * the column name for the phone field
     */
    const COL_PHONE = 'users.phone';

    /**
     * the column name for the job_place field
     */
    const COL_JOB_PLACE = 'users.job_place';

    /**
     * the column name for the address field
     */
    const COL_ADDRESS = 'users.address';

    /**
     * the column name for the position field
     */
    const COL_POSITION = 'users.position';

    /**
     * the column name for the degree field
     */
    const COL_DEGREE = 'users.degree';

    /**
     * the column name for the uid field
     */
    const COL_UID = 'users.uid';

    /**
     * the column name for the device field
     */
    const COL_DEVICE = 'users.device';

    /**
     * the column name for the is_member field
     */
    const COL_IS_MEMBER = 'users.is_member';

    /**
     * the column name for the data field
     */
    const COL_DATA = 'users.data';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Fullname', 'RegDate', 'Email', 'Phone', 'JobPlace', 'Address', 'Position', 'Degree', 'Uid', 'Device', 'IsMember', 'Data', ),
        self::TYPE_CAMELNAME     => array('id', 'fullname', 'regDate', 'email', 'phone', 'jobPlace', 'address', 'position', 'degree', 'uid', 'device', 'isMember', 'data', ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID, UserTableMap::COL_FULLNAME, UserTableMap::COL_REG_DATE, UserTableMap::COL_EMAIL, UserTableMap::COL_PHONE, UserTableMap::COL_JOB_PLACE, UserTableMap::COL_ADDRESS, UserTableMap::COL_POSITION, UserTableMap::COL_DEGREE, UserTableMap::COL_UID, UserTableMap::COL_DEVICE, UserTableMap::COL_IS_MEMBER, UserTableMap::COL_DATA, ),
        self::TYPE_FIELDNAME     => array('id', 'fullname', 'reg_date', 'email', 'phone', 'job_place', 'address', 'position', 'degree', 'uid', 'device', 'is_member', 'data', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Fullname' => 1, 'RegDate' => 2, 'Email' => 3, 'Phone' => 4, 'JobPlace' => 5, 'Address' => 6, 'Position' => 7, 'Degree' => 8, 'Uid' => 9, 'Device' => 10, 'IsMember' => 11, 'Data' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'fullname' => 1, 'regDate' => 2, 'email' => 3, 'phone' => 4, 'jobPlace' => 5, 'address' => 6, 'position' => 7, 'degree' => 8, 'uid' => 9, 'device' => 10, 'isMember' => 11, 'data' => 12, ),
        self::TYPE_COLNAME       => array(UserTableMap::COL_ID => 0, UserTableMap::COL_FULLNAME => 1, UserTableMap::COL_REG_DATE => 2, UserTableMap::COL_EMAIL => 3, UserTableMap::COL_PHONE => 4, UserTableMap::COL_JOB_PLACE => 5, UserTableMap::COL_ADDRESS => 6, UserTableMap::COL_POSITION => 7, UserTableMap::COL_DEGREE => 8, UserTableMap::COL_UID => 9, UserTableMap::COL_DEVICE => 10, UserTableMap::COL_IS_MEMBER => 11, UserTableMap::COL_DATA => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'fullname' => 1, 'reg_date' => 2, 'email' => 3, 'phone' => 4, 'job_place' => 5, 'address' => 6, 'position' => 7, 'degree' => 8, 'uid' => 9, 'device' => 10, 'is_member' => 11, 'data' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('users');
        $this->setPhpName('User');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\ConfBooker\\User');
        $this->setPackage('ConfBooker');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('fullname', 'Fullname', 'VARCHAR', true, 255, null);
        $this->addColumn('reg_date', 'RegDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('email', 'Email', 'VARCHAR', true, 140, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', true, 140, null);
        $this->addColumn('job_place', 'JobPlace', 'VARCHAR', false, 100, null);
        $this->addColumn('address', 'Address', 'VARCHAR', false, 200, null);
        $this->addColumn('position', 'Position', 'VARCHAR', false, 140, null);
        $this->addColumn('degree', 'Degree', 'VARCHAR', false, 24, null);
        $this->addColumn('uid', 'Uid', 'INTEGER', false, null, null);
        $this->addColumn('device', 'Device', 'VARCHAR', false, 200, null);
        $this->addColumn('is_member', 'IsMember', 'BOOLEAN', false, 1, false);
        $this->addColumn('data', 'Data', 'CLOB', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Participants', '\\ConfBooker\\Participants', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':id',
  ),
), null, null, 'Participantss', false);
        $this->addRelation('UserSpeciality', '\\ConfBooker\\UserSpeciality', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':id',
  ),
), null, null, 'UserSpecialities', false);
        $this->addRelation('UserFiles', '\\ConfBooker\\UserFiles', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Specialities', '\\ConfBooker\\Specialities', RelationMap::MANY_TO_MANY, array(), null, null, 'Specialitiess');
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? UserTableMap::CLASS_DEFAULT : UserTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (User object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UserTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UserTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UserTableMap::OM_CLASS;
            /** @var User $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UserTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = UserTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UserTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var User $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UserTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(UserTableMap::COL_ID);
            $criteria->addSelectColumn(UserTableMap::COL_FULLNAME);
            $criteria->addSelectColumn(UserTableMap::COL_REG_DATE);
            $criteria->addSelectColumn(UserTableMap::COL_EMAIL);
            $criteria->addSelectColumn(UserTableMap::COL_PHONE);
            $criteria->addSelectColumn(UserTableMap::COL_JOB_PLACE);
            $criteria->addSelectColumn(UserTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(UserTableMap::COL_POSITION);
            $criteria->addSelectColumn(UserTableMap::COL_DEGREE);
            $criteria->addSelectColumn(UserTableMap::COL_UID);
            $criteria->addSelectColumn(UserTableMap::COL_DEVICE);
            $criteria->addSelectColumn(UserTableMap::COL_IS_MEMBER);
            $criteria->addSelectColumn(UserTableMap::COL_DATA);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.fullname');
            $criteria->addSelectColumn($alias . '.reg_date');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.job_place');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.position');
            $criteria->addSelectColumn($alias . '.degree');
            $criteria->addSelectColumn($alias . '.uid');
            $criteria->addSelectColumn($alias . '.device');
            $criteria->addSelectColumn($alias . '.is_member');
            $criteria->addSelectColumn($alias . '.data');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME)->getTable(UserTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UserTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UserTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UserTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a User or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or User object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ConfBooker\User) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UserTableMap::DATABASE_NAME);
            $criteria->add(UserTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = UserQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UserTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UserTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UserQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a User or Criteria object.
     *
     * @param mixed               $criteria Criteria or User object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from User object
        }

        if ($criteria->containsKey(UserTableMap::COL_ID) && $criteria->keyContainsValue(UserTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UserTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = UserQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UserTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UserTableMap::buildTableMap();
