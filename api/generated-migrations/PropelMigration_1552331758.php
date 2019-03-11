<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1552331758.
 * Generated on 2019-03-11 19:15:58 by lexx
 */
class PropelMigration_1552331758
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'conf_booker_db' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `participants`

  DROP PRIMARY KEY,

  ADD `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `id`,

  ADD `user_id` INTEGER NOT NULL AFTER `date`,

  ADD `conf_id` INTEGER NOT NULL AFTER `user_id`,

  DROP `name`,

  ADD PRIMARY KEY (`id`,`user_id`,`conf_id`);

CREATE INDEX `participants_fi_69bd79` ON `participants` (`user_id`);

CREATE INDEX `participants_fi_2bf1ae` ON `participants` (`conf_id`);

ALTER TABLE `participants` ADD CONSTRAINT `participants_fk_69bd79`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`);

ALTER TABLE `participants` ADD CONSTRAINT `participants_fk_2bf1ae`
    FOREIGN KEY (`conf_id`)
    REFERENCES `conferences` (`id`);

CREATE TABLE `conferences`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'conf_booker_db' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `conferences`;

ALTER TABLE `participants` DROP FOREIGN KEY `participants_fk_69bd79`;

ALTER TABLE `participants` DROP FOREIGN KEY `participants_fk_2bf1ae`;

DROP INDEX `participants_fi_69bd79` ON `participants`;

DROP INDEX `participants_fi_2bf1ae` ON `participants`;

ALTER TABLE `participants`

  DROP PRIMARY KEY,

  ADD `name` VARCHAR(32) AFTER `id`,

  DROP `date`,

  DROP `user_id`,

  DROP `conf_id`,

  ADD PRIMARY KEY (`id`);

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}