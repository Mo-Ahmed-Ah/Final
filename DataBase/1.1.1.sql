CREATE DATABASE if NOT EXISTS MrBook;
USE mrbook;
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userid` INT NOT NULL,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `gender` VARCHAR(6) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `phone` CHAR(13) NULL,
  `url_address` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL DEFAULT now(),
  `updated_at` TIMESTAMP NULL DEFAULT now(),
  PRIMARY KEY (`id`),
  INDEX `email` (`email` ASC) ,
  INDEX `userid` (`userid` ASC) ,
  INDEX `first_Name` (`first_name` ASC) ,
  INDEX `last_name` (`last_name` ASC) ,
  INDEX `gender` (`gender` ASC) ,
  INDEX `url_address` (`url_address` ASC) ,
  UNIQUE INDEX `userid_UNIQUE` (`userid` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) 
  );
  
CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `post_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `post` TEXT NULL,
  `image` VARCHAR(500) NULL,
  `has_image` TINYINT(1) NOT NULL,
  `comments` INT NULL,
  `likes` INT NULL,
  `date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `post_id` (`post_id` ASC),
  INDEX `user_id` (`user_id` ASC),
  INDEX `likes` (`likes` ASC),
  INDEX `date` (`date` ASC),
  INDEX `comments` (`comments` ASC),
  INDEX `has_image` (`has_image` ASC)
);

