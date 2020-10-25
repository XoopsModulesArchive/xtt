# phpMyAdmin MySQL-Dump
# version 2.3.1-rc1
# http://www.phpmyadmin.net/ (download page)
#
# Generation Time: Oct 12, 2002 at 04:50 PM
# Server version: 3.23.52
# PHP Version: 4.1.2
# --------------------------------------------------------

#
# Table structure for table `xtt_categories`
#

CREATE TABLE xtt_categories (
    CategoryName VARCHAR(50) NOT NULL DEFAULT '',
    CategoryID   INT(11)     NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (CategoryID)
)
    ENGINE = ISAM;
# --------------------------------------------------------

#
# Table structure for table `xtt_clients`
#

CREATE TABLE xtt_clients (
    ClientName VARCHAR(50) NOT NULL DEFAULT '',
    ClientID   INT(11)     NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (ClientID)
)
    ENGINE = ISAM;
# --------------------------------------------------------

#
# Table structure for table `xtt_projects`
#

CREATE TABLE xtt_projects (
    ProjectID   INT(11)     NOT NULL AUTO_INCREMENT,
    ClientID    INT(11)     NOT NULL DEFAULT '0',
    ProjectName VARCHAR(50) NOT NULL DEFAULT '',
    PRIMARY KEY (ProjectID)
)
    ENGINE = ISAM;
# --------------------------------------------------------

#
# Table structure for table `xtt_task_data`
#

CREATE TABLE xtt_task_data (
    TaskID      INT(11)      NOT NULL AUTO_INCREMENT,
    ClientID    INT(11)      NOT NULL DEFAULT '0',
    ProjectID   INT(11)      NOT NULL DEFAULT '0',
    CategoryID  INT(11)      NOT NULL DEFAULT '0',
    uid         BIGINT(10)   NOT NULL DEFAULT '0',
    Billable    INT(11)      NOT NULL DEFAULT '0',
    Hours       FLOAT        NOT NULL DEFAULT '0',
    EntryDate   DATE         NOT NULL DEFAULT '0000-00-00',
    TaskDetails VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (TaskID)
)
    ENGINE = ISAM;
