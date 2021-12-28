CREATE TABLE `users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(200) NOT NULL COLLATE 'utf8_general_ci',
	`password` VARCHAR(200) NOT NULL COLLATE 'utf8_general_ci',
	`password_reset` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`created_at` DATETIME NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `EMAILUNIQUE` (`email`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

CREATE TABLE `uploads` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`title` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`file_name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`author_comments` TINYTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`average_rating` VARCHAR(50) NOT NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`users_rated` VARCHAR(50) NOT NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `FK__users` (`user_id`) USING BTREE,
	CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `notesrank`.`users` (`id`) ON UPDATE RESTRICT ON DELETE CASCADE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

CREATE TABLE `ratings` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT(10) UNSIGNED NOT NULL,
	`upload_id` INT(10) UNSIGNED NOT NULL,
	`rating` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `FK_ratings_users` (`user_id`) USING BTREE,
	INDEX `FK_ratings_uploads` (`upload_id`) USING BTREE,
	CONSTRAINT `FK_ratings_uploads` FOREIGN KEY (`upload_id`) REFERENCES `notesrank`.`uploads` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `FK_ratings_users` FOREIGN KEY (`user_id`) REFERENCES `notesrank`.`users` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;



INSERT INTO cs329e_mitra_syedraza.`users` (`id`, `email`, `password`, `created_at`) VALUES ('1', 'demo@gmail.com', '$2y$10$kjilRtPty5S4PBL8hijhZeo9OKRUXIrXrEJ4uAqVAUdYmJa6u5MQG', '2021-08-07 08:35:32');

INSERT INTO cs329e_mitra_syedraza.`uploads` (`id`, `user_id`, `title`, `file_name`, `author_comments`, `average_rating`, `users_rated`) VALUES ('1', '1', 'Home Work Assignment 1', 'uploads/20e98c750508d56623f37d911748cf1f.pdf', 'Home Work Assignment 1 comments ', '8', '1');
INSERT INTO cs329e_mitra_syedraza.`uploads` (`id`, `user_id`, `title`, `file_name`, `author_comments`, `average_rating`, `users_rated`) VALUES ('2', '1', 'Home Work Assignment 2', 'uploads/e118da3f80252d68ea8033695294247e.pdf', 'Home Work Assignment 2 comments', '9', '1');
INSERT INTO cs329e_mitra_syedraza.`uploads` (`id`, `user_id`, `title`, `file_name`, `author_comments`, `average_rating`, `users_rated`) VALUES ('3', '1', 'Home Work Assignment 3 comments', 'uploads/97e8643eed7a3d375ed986fc7b631e7b.pdf', 'Home Work Assignment 3 comments', '8', '1');
INSERT INTO cs329e_mitra_syedraza.`uploads` (`id`, `user_id`, `title`, `file_name`, `author_comments`, `average_rating`, `users_rated`) VALUES ('4', '1', 'Home Work Assignment 4', 'uploads/e73d18c9c3f55f871029bd2ed55f8be9.pdf', 'Home Work Assignment 4 comments', '9', '1');
INSERT INTO cs329e_mitra_syedraza.`uploads` (`id`, `user_id`, `title`, `file_name`, `author_comments`, `average_rating`, `users_rated`) VALUES ('5', '1', 'Home Work Assignment 5', 'uploads/b1a7c299c266462dc87a436ee25aa41c.pdf', 'Home Work Assignment 5 comments', '10', '1');
INSERT INTO cs329e_mitra_syedraza.`uploads` (`id`, `user_id`, `title`, `file_name`, `author_comments`, `average_rating`, `users_rated`) VALUES ('6', '1', 'Home Work Assignment 6', 'uploads/ec7a8291837b623ab55c63fe0665ee50.pdf', 'Home Work Assignment 6 comments', '8', '1');


INSERT INTO cs329e_mitra_syedraza.`ratings` (`id`, `user_id`, `upload_id`, `rating`) VALUES ('1', '1', '6', '8');
INSERT INTO cs329e_mitra_syedraza.`ratings` (`id`, `user_id`, `upload_id`, `rating`) VALUES ('2', '1', '5', '10');
INSERT INTO cs329e_mitra_syedraza.`ratings` (`id`, `user_id`, `upload_id`, `rating`) VALUES ('3', '1', '4', '9');
INSERT INTO cs329e_mitra_syedraza.`ratings` (`id`, `user_id`, `upload_id`, `rating`) VALUES ('4', '1', '3', '8');
INSERT INTO cs329e_mitra_syedraza.`ratings` (`id`, `user_id`, `upload_id`, `rating`) VALUES ('5', '1', '2', '9');
INSERT INTO cs329e_mitra_syedraza.`ratings` (`id`, `user_id`, `upload_id`, `rating`) VALUES ('6', '1', '1', '8');
