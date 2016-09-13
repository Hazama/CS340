/*
******************************************************************************
Name: Final Project for CS340 - Summer 2016
Group Members: Brittney McInnis, Jeff Goss
******************************************************************************
*/

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS medical_record;
DROP TABLE IF EXISTS department;
DROP TABLE IF EXISTS hospital_staff;
DROP TABLE IF EXISTS lab_test;
DROP TABLE IF EXISTS patient_medical_record;
DROP TABLE IF EXISTS patient_lab_test;
DROP TABLE IF EXISTS patient_staff_history;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE patients (
            id int(11) NOT NULL AUTO_INCREMENT,
            fname varchar(255) ,
            lname varchar(255),
            birthdate date,
            weight int,
            height int,
            sex char(1),
            pat_status varchar(255) NOT NULL,
            admit_date date NOT NULL,
            discharge date,
            PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO patients VALUES (1, 'JESSICA', 'JONES', '1979-08-19', 120, 65, 'F', 'INPATIENT', '2015-08-19', NULL),
							(2, 'PETER', 'PARKER', '1990-11-12', 165, 68, 'M', 'OUTPATIENT', '2016-06-09', '2016-06-09'),
							(3, 'TONY', 'STARK', '1977-03-23', 180, 70, 'M', 'OUTPATIENT', '2015-10-19', '2015-10-19');

CREATE TABLE medical_record (
            id int(11) NOT NULL AUTO_INCREMENT,
            description varchar(255) NOT NULL,
            PRIMARY KEY (id),
    		UNIQUE KEY (description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO medical_record VALUES (1, 'HEART DISEASE'), (2, 'CANCER'), (3, 'HEART ATTACK'), (4, 'STROKE'), (5, 'ARTHRITIS'), (6, 'TOBACCO USE'), (7,'ALCOHOL USE'), (8,'AUTOIMMUNE');


CREATE TABLE department (
            id int(11) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            bldg varchar(255) NOT NULL,
            phone varchar(255) NOT NULL,
            ann_budget float(20, 2) NOT NULL,
            ann_expend float(20, 2) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO department VALUES (1, 'CARDIOLOGY', 'EAST WING', '555-555-5555', 45000000.00, 53000000.00),
							  (2, 'IMAGING', 'WEST WING', '555-555-5345', 60000000.00, 55000000.00),
							  (3, 'ICU', 'WEST WING', '555-555-5346', 53000000.00, 48000000.00),
							  (4, 'RECEPTION', 'FRONT ENTRANCE', '555-555-5005', 40000.00, 35000.00),
							  (5, 'OBSTRETRICS AND GYNECOLOGY', 'EAST WING', '555-555-5556', 30000000.00, 34000000.00),
							  (6, 'PEDIATRICS', 'EAST WING', '555-555-5557', 18000000.00, 17500000.00),
							  (7, 'NEUROLOGY', 'SOUTH WING', '555-555-6050', 25000000.00, 28000000.00);


CREATE TABLE hospital_staff (
            id int(11) NOT NULL AUTO_INCREMENT,
            fname varchar(255) NOT NULL ,
            lname varchar(255) NOT NULL,
            title varchar(255) NOT NULL,
            hire date NOT NULL,
            salary float(20, 2) NOT NULL, 
            dept int(11) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (dept) REFERENCES department (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO hospital_staff VALUES (1, 'LEX', 'LUTHOR', 'SURGEON', '2002-12-25', 500000.00, 1),
						 (2, 'OTTO', 'OCTAVIUS', 'PHYSICIAN', '2012-11-17', 300000.00, 6),
						 (3, 'NORMAN', 'OSBORNE', 'SURGEON', '2005-04-20', 600000.00, 7),
						 (4, 'HARLEY', 'QUINN', 'NURSE PRACTITIONER', '2001-09-12', 100000.00, 5);


CREATE TABLE lab_test (
            id int(11) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            description varchar(255) NOT NULL,
            unit varchar(255),
            low float(10, 1),
            high float(10, 1),
            PRIMARY KEY (id),
            UNIQUE KEY (name, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO lab_test VALUES (1, 'PSA', 'PROSTATE SPECIFIC ANTIGEN', 'NG/ML', 4.0, 10.0), 
                            (2, 'ALP', 'ALKALINE PHOSPHATASE', 'U/L', 25.0, 100.0),
                            (3, 'BUN', 'BLOOD UREA NITROGEN', 'MG/DL', 10.0, 20.0),
                            (4, 'CRP', 'C-REACTIVE PROTEIN', 'MG/DL', NULL, 1.0),
                            (5, 'LDL', 'LDL CHOLESTEROL', 'MG/DL', NULL, 100.0);

CREATE TABLE patient_medical_record (
            pid int(11) NOT NULL,
            mrid int(11) NOT NULL,
            PRIMARY KEY (pid, mrid),
            FOREIGN KEY (pid) REFERENCES patients (id) ON DELETE RESTRICT ON UPDATE CASCADE,
            FOREIGN KEY (mrid) REFERENCES medical_record (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO patient_medical_record VALUES (3, 1);


CREATE TABLE patient_lab_test (
            pid int(11) NOT NULL,
            ltid int(11) NOT NULL,
            test_date date,
            result float(10, 1),
            PRIMARY KEY (pid, ltid),
            FOREIGN KEY (pid) REFERENCES patients (id) ON UPDATE CASCADE ON DELETE RESTRICT,
            FOREIGN KEY (ltid) REFERENCES lab_test (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO patient_lab_test VALUES (2, 1, '2016-06-09', 25.0);

CREATE TABLE patient_staff_history (
            pid int(11) NOT NULL,
            sid int(11) NOT NULL,
            description varchar(255),
            proc_date date,
            PRIMARY KEY (pid, sid, proc_date),
            FOREIGN KEY (pid) REFERENCES patients (id) ON UPDATE CASCADE ON DELETE RESTRICT,
            FOREIGN KEY (sid) REFERENCES hospital_staff (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO patient_staff_history VALUES (2, 2, 'ANNUAL PHYSICAL', '2016-06-09'), (1, 3, 'REMOVE APPENDIX', '2015-08-17');
