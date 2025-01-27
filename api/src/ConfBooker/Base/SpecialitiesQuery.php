<?php

namespace ConfBooker\Base;

use \Exception;
use \PDO;
use ConfBooker\Specialities as ChildSpecialities;
use ConfBooker\SpecialitiesQuery as ChildSpecialitiesQuery;
use ConfBooker\Map\SpecialitiesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'specialities' table.
 *
 *
 *
 * @method     ChildSpecialitiesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSpecialitiesQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method     ChildSpecialitiesQuery groupById() Group by the id column
 * @method     ChildSpecialitiesQuery groupByName() Group by the name column
 *
 * @method     ChildSpecialitiesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSpecialitiesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSpecialitiesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSpecialitiesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSpecialitiesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSpecialitiesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSpecialitiesQuery leftJoinUserSpeciality($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserSpeciality relation
 * @method     ChildSpecialitiesQuery rightJoinUserSpeciality($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserSpeciality relation
 * @method     ChildSpecialitiesQuery innerJoinUserSpeciality($relationAlias = null) Adds a INNER JOIN clause to the query using the UserSpeciality relation
 *
 * @method     ChildSpecialitiesQuery joinWithUserSpeciality($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserSpeciality relation
 *
 * @method     ChildSpecialitiesQuery leftJoinWithUserSpeciality() Adds a LEFT JOIN clause and with to the query using the UserSpeciality relation
 * @method     ChildSpecialitiesQuery rightJoinWithUserSpeciality() Adds a RIGHT JOIN clause and with to the query using the UserSpeciality relation
 * @method     ChildSpecialitiesQuery innerJoinWithUserSpeciality() Adds a INNER JOIN clause and with to the query using the UserSpeciality relation
 *
 * @method     \ConfBooker\UserSpecialityQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSpecialities findOne(ConnectionInterface $con = null) Return the first ChildSpecialities matching the query
 * @method     ChildSpecialities findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSpecialities matching the query, or a new ChildSpecialities object populated from the query conditions when no match is found
 *
 * @method     ChildSpecialities findOneById(int $id) Return the first ChildSpecialities filtered by the id column
 * @method     ChildSpecialities findOneByName(string $name) Return the first ChildSpecialities filtered by the name column *

 * @method     ChildSpecialities requirePk($key, ConnectionInterface $con = null) Return the ChildSpecialities by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSpecialities requireOne(ConnectionInterface $con = null) Return the first ChildSpecialities matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSpecialities requireOneById(int $id) Return the first ChildSpecialities filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSpecialities requireOneByName(string $name) Return the first ChildSpecialities filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSpecialities[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSpecialities objects based on current ModelCriteria
 * @method     ChildSpecialities[]|ObjectCollection findById(int $id) Return ChildSpecialities objects filtered by the id column
 * @method     ChildSpecialities[]|ObjectCollection findByName(string $name) Return ChildSpecialities objects filtered by the name column
 * @method     ChildSpecialities[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SpecialitiesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ConfBooker\Base\SpecialitiesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'conf_booker_db', $modelName = '\\ConfBooker\\Specialities', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSpecialitiesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSpecialitiesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSpecialitiesQuery) {
            return $criteria;
        }
        $query = new ChildSpecialitiesQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSpecialities|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SpecialitiesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SpecialitiesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSpecialities A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `name` FROM `specialities` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSpecialities $obj */
            $obj = new ChildSpecialities();
            $obj->hydrate($row);
            SpecialitiesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildSpecialities|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildSpecialitiesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SpecialitiesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSpecialitiesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SpecialitiesTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSpecialitiesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SpecialitiesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SpecialitiesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SpecialitiesTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSpecialitiesQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SpecialitiesTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related \ConfBooker\UserSpeciality object
     *
     * @param \ConfBooker\UserSpeciality|ObjectCollection $userSpeciality the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSpecialitiesQuery The current query, for fluid interface
     */
    public function filterByUserSpeciality($userSpeciality, $comparison = null)
    {
        if ($userSpeciality instanceof \ConfBooker\UserSpeciality) {
            return $this
                ->addUsingAlias(SpecialitiesTableMap::COL_ID, $userSpeciality->getSpecId(), $comparison);
        } elseif ($userSpeciality instanceof ObjectCollection) {
            return $this
                ->useUserSpecialityQuery()
                ->filterByPrimaryKeys($userSpeciality->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserSpeciality() only accepts arguments of type \ConfBooker\UserSpeciality or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserSpeciality relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSpecialitiesQuery The current query, for fluid interface
     */
    public function joinUserSpeciality($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserSpeciality');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserSpeciality');
        }

        return $this;
    }

    /**
     * Use the UserSpeciality relation UserSpeciality object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ConfBooker\UserSpecialityQuery A secondary query class using the current class as primary query
     */
    public function useUserSpecialityQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserSpeciality($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserSpeciality', '\ConfBooker\UserSpecialityQuery');
    }

    /**
     * Filter the query by a related User object
     * using the user_speciality table as cross reference
     *
     * @param User $user the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSpecialitiesQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useUserSpecialityQuery()
            ->filterByUser($user, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSpecialities $specialities Object to remove from the list of results
     *
     * @return $this|ChildSpecialitiesQuery The current query, for fluid interface
     */
    public function prune($specialities = null)
    {
        if ($specialities) {
            $this->addUsingAlias(SpecialitiesTableMap::COL_ID, $specialities->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the specialities table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SpecialitiesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SpecialitiesTableMap::clearInstancePool();
            SpecialitiesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SpecialitiesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SpecialitiesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SpecialitiesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SpecialitiesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SpecialitiesQuery
