DROP TABLE IF EXISTS `civimembershipperiod_track`; 

-- /*******************************************************
-- *
-- * civimembershipperiod_track
-- *
-- * Record Membership Periods.
-- *
-- *******************************************************/
CREATE TABLE `civimembershipperiod_track` (
     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Period Track ID',
     `period` varchar(55) NOT NULL   COMMENT 'Period That Record ?',
     `contact_id` int unsigned DEFAULT NULL COMMENT 'FK to Contact ID ',
     `membership_id` int unsigned  NULL  COMMENT 'FK to memberships ID ',
     `membership_name` varchar(255) NOT NULL   COMMENT 'Membership Name That used ?',
     `contribution_id` int unsigned    COMMENT 'FK to Contribution ID for the contact that used this discount',
     `start_date` datetime    COMMENT 'Start Date of Membership',
     `end_date` datetime    COMMENT 'End Date Of Membership',
     `entity_table` varchar(64) NOT NULL   COMMENT 'Name of table where item being referenced is stored',
     `entity_id` int unsigned NOT NULL   COMMENT 'Foreign key to the referenced item',

     PRIMARY KEY ( `id` ),

     CONSTRAINT FK_civimembershipperiod_track_membership_id FOREIGN KEY (`membership_id`) REFERENCES `civicrm_membership`(`id`) ON DELETE SET NULL, 
     CONSTRAINT FK_civimembershipperiod_track_contact_id FOREIGN KEY (`contact_id`) REFERENCES `civicrm_contact`(`id`) ON DELETE SET NULL,
     CONSTRAINT FK_civimembershipperiod_track_contribution_id FOREIGN KEY (`contribution_id`) REFERENCES `civicrm_contribution`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;
