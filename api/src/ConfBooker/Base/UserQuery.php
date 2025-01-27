<?php

namespace ConfBooker\Base;

use \Exception;
use \PDO;
use ConfBooker\User as ChildUser;
use ConfBooker\UserQuery as ChildUserQuery;
use ConfBooker\Map\UserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'users' table.
 *
 *
 *
 * @method     ChildUserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUserQuery orderByFullname($order = Criteria::ASC) Order by the fullname column
 * @method     ChildUserQuery orderByRegDate($order = Criteria::ASC) Order by the reg_date column
 * @method     ChildUserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUserQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildUserQuery orderByJobPlace($order = Criteria::ASC) Order by the job_place column
 * @method     ChildUserQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildUserQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildUserQuery orderByDegree($order = Criteria::ASC) Order by the degree column
 * @method     ChildUserQuery orderByUid($order = Criteria::ASC) Order by the uid column
 * @method     ChildUserQuery orderByDevice($order = Criteria::ASC) Order by the device column
 * @method     ChildUserQuery orderByIsMember($order = Criteria::ASC) Order by the is_member column
 * @method     ChildUserQuery orderByData($order = Criteria::ASC) Order by the data column
 *
 * @method     ChildUserQuery groupById() Group by the id column
 * @method     ChildUserQuery groupByFullname() Group by the fullname column
 * @method     ChildUserQuery groupByRegDate() Group by the reg_date column
 * @method     ChildUserQuery groupByEmail() Group by the email column
 * @method     ChildUserQuery groupByPhone() Group by the phone column
 * @method     ChildUserQuery groupByJobPlace() Group by the job_place column
 * @method     ChildUserQuery groupByAddress() Group by the address column
 * @method     ChildUserQuery groupByPosition() Group by the position column
 * @method     ChildUserQuery groupByDegree() Group by the degree column
 * @method     ChildUserQuery groupByUid() Group by the uid column
 * @method     ChildUserQuery groupByDevice() Group by the device column
 * @method     ChildUserQuery groupByIsMember() Group by the is_member column
 * @method     ChildUserQuery groupByData() Group by the data column
 *
 * @method     ChildUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserQuery leftJoinParticipants($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participants relation
 * @method     ChildUserQuery rightJoinParticipants($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participants relation
 * @method     ChildUserQuery innerJoinParticipants($relationAlias = null) Adds a INNER JOIN clause to the query using the Participants relation
 *
 * @method     ChildUserQuery joinWithParticipants($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Participants relation
 *
 * @method     ChildUserQuery leftJoinWithParticipants() Adds a LEFT JOIN clause and with to the query using the Participants relation
 * @method     ChildUserQuery rightJoinWithParticipants() Adds a RIGHT JOIN clause and with to the query using the Participants relation
 * @method     ChildUserQuery innerJoinWithParticipants() Adds a INNER JOIN clause and with to the query using the Participants relation
 *
 * @method     ChildUserQuery leftJoinUserSpeciality($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserSpeciality relation
 * @method     ChildUserQuery rightJoinUserSpeciality($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserSpeciality relation
 * @method     ChildUserQuery innerJoinUserSpeciality($relationAlias = null) Adds a INNER JOIN clause to the query using the UserSpeciality relation
 *
 * @method     ChildUserQuery joinWithUserSpeciality($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserSpeciality relation
 *
 * @method     ChildUserQuery leftJoinWithUserSpeciality() Adds a LEFT JOIN clause and with to the query using the UserSpeciality relation
 * @method     ChildUserQuery rightJoinWithUserSpeciality() Adds a RIGHT JOIN clause and with to the query using the UserSpeciality relation
 * @method     ChildUserQuery innerJoinWithUserSpeciality() Adds a INNER JOIN clause and with to the query using the UserSpeciality relation
 *
 * @method     ChildUserQuery leftJoinUserFiles($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserFiles relation
 * @method     ChildUserQuery rightJoinUserFiles($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserFiles relation
 * @method     ChildUserQuery innerJoinUserFiles($relationAlias = null) Adds a INNER JOIN clause to the query using the UserFiles relation
 *
 * @method     ChildUserQuery joinWithUserFiles($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserFiles relation
 *
 * @method     ChildUserQuery leftJoinWithUserFiles() Adds a LEFT JOIN clause and with to the query using the UserFiles relation
 * @method     ChildUserQuery rightJoinWithUserFiles() Adds a RIGHT JOIN clause and with to the query using the UserFiles relation
 * @method     ChildUserQuery innerJoinWithUserFiles() Adds a INNER JOIN clause and with to the query using the UserFiles relation
 *
 * @method     \ConfBooker\ParticipantsQuery|\ConfBooker\UserSpecialityQuery|\ConfBooker\UserFilesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUser findOne(ConnectionInterface $con = null) Return the first ChildUser matching the query
 * @method     ChildUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUser matching the query, or a new ChildUser object populated from the query conditions when no match is found
 *
 * @method     ChildUser findOneById(int $id) Return the first ChildUser filtered by the id column
 * @method     ChildUser findOneByFullname(string $fullname) Return the first ChildUser filtered by the fullname column
 * @method     ChildUser findOneByRegDate(string $reg_date) Return the first ChildUser filtered by the reg_date column
 * @method     ChildUser findOneByEmail(string $email) Return the first ChildUser filtered by the email column
 * @method     ChildUser findOneByPhone(string $phone) Return the first ChildUser filtered by the phone column
 * @method     ChildUser findOneByJobPlace(string $job_place) Return the first ChildUser filtered by the job_place column
 * @method     ChildUser findOneByAddress(string $address) Return the first ChildUser filtered by the address column
 * @method     ChildUser findOneByPosition(string $position) Return the first ChildUser filtered by the position column
 * @method     ChildUser findOneByDegree(string $degree) Return the first ChildUser filtered by the degree column
 * @method     ChildUser findOneByUid(int $uid) Return the first ChildUser filtered by the uid column
 * @method     ChildUser findOneByDevice(string $device) Return the first ChildUser filtered by the device column
 * @method     ChildUser findOneByIsMember(boolean $is_member) Return the first ChildUser filtered by the is_member column
 * @method     ChildUser findOneByData(string $data) Return the first ChildUser filtered by the data column *

 * @method     ChildUser requirePk($key, ConnectionInterface $con = null) Return the ChildUser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOne(ConnectionInterface $con = null) Return the first ChildUser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser requireOneById(int $id) Return the first ChildUser filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByFullname(string $fullname) Return the first ChildUser filtered by the fullname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByRegDate(string $reg_date) Return the first ChildUser filtered by the reg_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByEmail(string $email) Return the first ChildUser filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPhone(string $phone) Return the first ChildUser filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByJobPlace(string $job_place) Return the first ChildUser filtered by the job_place column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByAddress(string $address) Return the first ChildUser filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPosition(string $position) Return the first ChildUser filtered by the position column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByDegree(string $degree) Return the first ChildUser filtered by the degree column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByUid(int $uid) Return the first ChildUser filtered by the uid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByDevice(string $device) Return the first ChildUser filtered by the device column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByIsMember(boolean $is_member) Return the first ChildUser filtered by the is_member column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByData(string $data) Return the first ChildUser filtered by the data column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUser objects based on current ModelCriteria
 * @method     ChildUser[]|ObjectCollection findById(int $id) Return ChildUser objects filtered by the id column
 * @method     ChildUser[]|ObjectCollection findByFullname(string $fullname) Return ChildUser objects filtered by the fullname column
 * @method     ChildUser[]|ObjectCollection findByRegDate(string $reg_date) Return ChildUser objects filtered by the reg_date column
 * @method     ChildUser[]|ObjectCollection findByEmail(string $email) Return ChildUser objects filtered by the email column
 * @method     ChildUser[]|ObjectCollection findByPhone(string $phone) Return ChildUser objects filtered by the phone column
 * @method     ChildUser[]|ObjectCollection findByJobPlace(string $job_place) Return ChildUser objects filtered by the job_place column
 * @method     ChildUser[]|ObjectCollection findByAddress(string $address) Return ChildUser objects filtered by the address column
 * @method     ChildUser[]|ObjectCollection findByPosition(string $position) Return ChildUser objects filtered by the position column
 * @method     ChildUser[]|ObjectCollection findByDegree(string $degree) Return ChildUser objects filtered by the degree column
 * @method     ChildUser[]|ObjectCollection findByUid(int $uid) Return ChildUser objects filtered by the uid column
 * @method     ChildUser[]|ObjectCollection findByDevice(string $device) Return ChildUser objects filtered by the device column
 * @method     ChildUser[]|ObjectCollection findByIsMember(boolean $is_member) Return ChildUser objects filtered by the is_member column
 * @method     ChildUser[]|ObjectCollection findByData(string $data) Return ChildUser objects filtered by the data column
 * @method     ChildUser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \ConfBooker\Base\UserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'conf_booker_db', $modelName = '\\ConfBooker\\User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserQuery) {
            return $criteria;
        }
        $query = new ChildUserQuery();
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `fullname`, `reg_date`, `email`, `phone`, `job_place`, `address`, `position`, `degree`, `uid`, `device`, `is_member`, `data` FROM `users` WHERE `id` = :p0';
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
            /** @var ChildUser $obj */
            $obj = new ChildUser();
            $obj->hydrate($row);
            UserTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the fullname column
     *
     * Example usage:
     * <code>
     * $query->filterByFullname('fooValue');   // WHERE fullname = 'fooValue'
     * $query->filterByFullname('%fooValue%', Criteria::LIKE); // WHERE fullname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fullname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByFullname($fullname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_FULLNAME, $fullname, $comparison);
    }

    /**
     * Filter the query on the reg_date column
     *
     * Example usage:
     * <code>
     * $query->filterByRegDate('2011-03-14'); // WHERE reg_date = '2011-03-14'
     * $query->filterByRegDate('now'); // WHERE reg_date = '2011-03-14'
     * $query->filterByRegDate(array('max' => 'yesterday')); // WHERE reg_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $regDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByRegDate($regDate = null, $comparison = null)
    {
        if (is_array($regDate)) {
            $useMinMax = false;
            if (isset($regDate['min'])) {
                $this->addUsingAlias(UserTableMap::COL_REG_DATE, $regDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($regDate['max'])) {
                $this->addUsingAlias(UserTableMap::COL_REG_DATE, $regDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_REG_DATE, $regDate, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%', Criteria::LIKE); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the job_place column
     *
     * Example usage:
     * <code>
     * $query->filterByJobPlace('fooValue');   // WHERE job_place = 'fooValue'
     * $query->filterByJobPlace('%fooValue%', Criteria::LIKE); // WHERE job_place LIKE '%fooValue%'
     * </code>
     *
     * @param     string $jobPlace The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByJobPlace($jobPlace = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($jobPlace)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_JOB_PLACE, $jobPlace, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition('fooValue');   // WHERE position = 'fooValue'
     * $query->filterByPosition('%fooValue%', Criteria::LIKE); // WHERE position LIKE '%fooValue%'
     * </code>
     *
     * @param     string $position The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($position)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the degree column
     *
     * Example usage:
     * <code>
     * $query->filterByDegree('fooValue');   // WHERE degree = 'fooValue'
     * $query->filterByDegree('%fooValue%', Criteria::LIKE); // WHERE degree LIKE '%fooValue%'
     * </code>
     *
     * @param     string $degree The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByDegree($degree = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($degree)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_DEGREE, $degree, $comparison);
    }

    /**
     * Filter the query on the uid column
     *
     * Example usage:
     * <code>
     * $query->filterByUid(1234); // WHERE uid = 1234
     * $query->filterByUid(array(12, 34)); // WHERE uid IN (12, 34)
     * $query->filterByUid(array('min' => 12)); // WHERE uid > 12
     * </code>
     *
     * @param     mixed $uid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUid($uid = null, $comparison = null)
    {
        if (is_array($uid)) {
            $useMinMax = false;
            if (isset($uid['min'])) {
                $this->addUsingAlias(UserTableMap::COL_UID, $uid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($uid['max'])) {
                $this->addUsingAlias(UserTableMap::COL_UID, $uid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_UID, $uid, $comparison);
    }

    /**
     * Filter the query on the device column
     *
     * Example usage:
     * <code>
     * $query->filterByDevice('fooValue');   // WHERE device = 'fooValue'
     * $query->filterByDevice('%fooValue%', Criteria::LIKE); // WHERE device LIKE '%fooValue%'
     * </code>
     *
     * @param     string $device The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByDevice($device = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($device)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_DEVICE, $device, $comparison);
    }

    /**
     * Filter the query on the is_member column
     *
     * Example usage:
     * <code>
     * $query->filterByIsMember(true); // WHERE is_member = true
     * $query->filterByIsMember('yes'); // WHERE is_member = true
     * </code>
     *
     * @param     boolean|string $isMember The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByIsMember($isMember = null, $comparison = null)
    {
        if (is_string($isMember)) {
            $isMember = in_array(strtolower($isMember), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserTableMap::COL_IS_MEMBER, $isMember, $comparison);
    }

    /**
     * Filter the query on the data column
     *
     * Example usage:
     * <code>
     * $query->filterByData('fooValue');   // WHERE data = 'fooValue'
     * $query->filterByData('%fooValue%', Criteria::LIKE); // WHERE data LIKE '%fooValue%'
     * </code>
     *
     * @param     string $data The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByData($data = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($data)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_DATA, $data, $comparison);
    }

    /**
     * Filter the query by a related \ConfBooker\Participants object
     *
     * @param \ConfBooker\Participants|ObjectCollection $participants the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByParticipants($participants, $comparison = null)
    {
        if ($participants instanceof \ConfBooker\Participants) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $participants->getUserId(), $comparison);
        } elseif ($participants instanceof ObjectCollection) {
            return $this
                ->useParticipantsQuery()
                ->filterByPrimaryKeys($participants->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByParticipants() only accepts arguments of type \ConfBooker\Participants or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Participants relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinParticipants($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Participants');

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
            $this->addJoinObject($join, 'Participants');
        }

        return $this;
    }

    /**
     * Use the Participants relation Participants object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ConfBooker\ParticipantsQuery A secondary query class using the current class as primary query
     */
    public function useParticipantsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinParticipants($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Participants', '\ConfBooker\ParticipantsQuery');
    }

    /**
     * Filter the query by a related \ConfBooker\UserSpeciality object
     *
     * @param \ConfBooker\UserSpeciality|ObjectCollection $userSpeciality the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserSpeciality($userSpeciality, $comparison = null)
    {
        if ($userSpeciality instanceof \ConfBooker\UserSpeciality) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $userSpeciality->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \ConfBooker\UserFiles object
     *
     * @param \ConfBooker\UserFiles|ObjectCollection $userFiles the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByUserFiles($userFiles, $comparison = null)
    {
        if ($userFiles instanceof \ConfBooker\UserFiles) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $userFiles->getUserId(), $comparison);
        } elseif ($userFiles instanceof ObjectCollection) {
            return $this
                ->useUserFilesQuery()
                ->filterByPrimaryKeys($userFiles->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserFiles() only accepts arguments of type \ConfBooker\UserFiles or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserFiles relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinUserFiles($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserFiles');

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
            $this->addJoinObject($join, 'UserFiles');
        }

        return $this;
    }

    /**
     * Use the UserFiles relation UserFiles object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ConfBooker\UserFilesQuery A secondary query class using the current class as primary query
     */
    public function useUserFilesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserFiles($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserFiles', '\ConfBooker\UserFilesQuery');
    }

    /**
     * Filter the query by a related Specialities object
     * using the user_speciality table as cross reference
     *
     * @param Specialities $specialities the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterBySpecialities($specialities, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useUserSpecialityQuery()
            ->filterBySpecialities($specialities, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUser $user Object to remove from the list of results
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserTableMap::COL_ID, $user->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTableMap::clearInstancePool();
            UserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserQuery
