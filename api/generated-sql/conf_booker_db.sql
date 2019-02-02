
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

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

-- ---------------------------------------------------------------------
-- specialities
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `specialities`;

CREATE TABLE `specialities`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_speciality
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_speciality`;

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

-- ---------------------------------------------------------------------
-- user_files
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_files`;

CREATE TABLE `user_files`
(
    `user_id` INTEGER NOT NULL,
    `name` VARCHAR(32),
    `filename` VARCHAR(100),
    PRIMARY KEY (`user_id`),
    CONSTRAINT `user_files_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
) ENGINE=InnoDB COMMENT='User files';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
