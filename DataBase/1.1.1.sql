CREATE DATABASE if NOT EXISTS mrbook;
USE mrbook;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `gender` VARCHAR(6) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `phone` CHAR(13) NULL,
  `profile_image` VARCHAR(1000) NULL,
  `cover_image` VARCHAR(1000) NULL,
  `url_address` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL DEFAULT now(),
  `updated_at` TIMESTAMP NULL DEFAULT now(),
  PRIMARY KEY (`user_id`),
  INDEX `email` (`email` ASC),
  INDEX `first_Name` (`first_name` ASC),
  INDEX `last_name` (`last_name` ASC),
  INDEX `gender` (`gender` ASC),
  INDEX `url_address` (`url_address` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC)
);
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` INT NOT NULL AUTO_INCREMENT,
  `post` TEXT NULL,
  `image` VARCHAR(500) NULL,
  `has_image` TINYINT(1) NOT NULL,
  `comments` INT NULL,
  `likes` INT NULL,
  `is_profile_image` TINYINT(1) NULL,
  `is_cover_image` TINYINT(1) NULL,
  `date` TIMESTAMP NULL DEFAULT now(),
  `user_id` INT NOT NULL,
  PRIMARY KEY (`post_id`),
  INDEX `likes` (`likes` ASC) ,
  INDEX `data` (`date` ASC) ,
  INDEX `comments` (`comments` ASC) ,
  INDEX `has_image` (`has_image` ASC) ,
  INDEX `user_id` (`user_id` ASC) ,
  CONSTRAINT `fk_posts_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    );

