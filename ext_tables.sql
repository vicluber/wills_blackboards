#
# Add SQL definition of database tables
#
CREATE TABLE tx_willsblackboards_domain_model_blackboard (
   tstamp int(11) DEFAULT 0 NOT NULL,
   crdate int(11) DEFAULT 0 NOT NULL,
   title varchar(255) DEFAULT '' NOT NULL,
   description text NOT NULL,
   category int(11) DEFAULT 0 NOT NULL,
   user int(11) DEFAULT 0 NOT NULL,
   image varchar(255) DEFAULT 0,
   phone_number varchar(255) DEFAULT 0 NOT NULL
);
CREATE TABLE tx_willsblackboards_domain_model_comment (
   tstamp int(11) DEFAULT 0 NOT NULL,
   crdate int(11) DEFAULT 0 NOT NULL,
   text varchar(255) DEFAULT '' NOT NULL,
   user int(11) DEFAULT 0 NOT NULL,
   blackboard int(11) DEFAULT 0 NOT NULL,
);