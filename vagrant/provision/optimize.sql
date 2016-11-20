# change primary from ISBN to Book-ID
ALTER TABLE `BX-Books` DROP PRIMARY KEY;
ALTER TABLE `BX-Books` ADD `Book-ID` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`Book-ID`);
ALTER TABLE `BX-Books` ADD UNIQUE INDEX ISBN (ISBN);
ALTER TABLE `BX-Book-Ratings` ADD `Book-ID` INT(11) NOT NULL FIRST;
UPDATE `BX-Book-Ratings` LEFT JOIN `BX-Books` ON (`BX-Book-Ratings`.`ISBN` = `BX-Books`.`ISBN`) SET `BX-Book-Ratings`.`Book-ID` = `BX-Books`.`Book-ID`;
DELETE FROM `BX-Book-Ratings` WHERE `Book-ID` IS NULL;
ALTER TABLE `BX-Book-Ratings` DROP PRIMARY KEY;
ALTER TABLE `BX-Book-Ratings` ADD PRIMARY KEY (`Book-ID`, `User-ID`);
ALTER TABLE `BX-Book-Ratings` DROP `ISBN`;

# explode country from Location
ALTER TABLE `BX-Users` ADD `Country` VARCHAR(15) NOT NULL AFTER `Location`;
ALTER TABLE `BX-Users` ADD INDEX Country (`Country`);
UPDATE `BX-Users` SET `Country` = TRIM(SUBSTRING_INDEX(`Location`, ',', -1));