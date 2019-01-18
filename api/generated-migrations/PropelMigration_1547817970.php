<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1547817970.
 * Generated on 2019-01-18 13:26:10 by lexx
 */
class PropelMigration_1547817970
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
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `position` VARCHAR(24) NOT NULL,
    `email` VARCHAR(24) NOT NULL,
    `phone` VARCHAR(24) NOT NULL,
    `job_place` INTEGER NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `specialities`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `user_speciality`
(
    `user_id` INTEGER NOT NULL,
    `spec_id` INTEGER NOT NULL,
    PRIMARY KEY (`user_id`,`spec_id`),
    INDEX `user_speciality_fi_c1c986` (`spec_id`),
    CONSTRAINT `user_speciality_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`),
    CONSTRAINT `user_speciality_fk_c1c986`
        FOREIGN KEY (`spec_id`)
        REFERENCES `specialities` (`id`)
) ENGINE=InnoDB;

CREATE TABLE `user_files`
(
    `user_id` INTEGER NOT NULL,
    `name` VARCHAR(32),
    `filename` VARCHAR(100),
    PRIMARY KEY (`user_id`),
    CONSTRAINT `user_files_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB COMMENT=\'User files\';

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
  'default' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `users`;

DROP TABLE IF EXISTS `specialities`;

DROP TABLE IF EXISTS `user_speciality`;

DROP TABLE IF EXISTS `user_files`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}