use itaps;

INSERT INTO Class(title, link, credits, pep_credits)
VALUES ('SI 523 - Information and Control', 'http://genericlink', 3, 0);

INSERT INTO Class(title, link, credits, pep_credits)
VALUES('SI 530 - Principles in Management', 'http://anotherlink', 3, 0);

INSERT INTO Requirements(specialization, description, credits)
VALUES('MSI', 'Foundations' 9);

INSERT INTO Requirements(specialization, description, credits)
VALUES('MSI','Management and Research', 3);

INSERT INTO Requirements(specialization, description, credits)
VALUES('MSI', 'PEP Credits', 8);

INSERT INTO Requirements(specialization, description, credits)
VALUES('MSI', 'Cognate', 3);

INSERT INTO Requirements(specialization, description, credits)
VALUES('HCI', 'Required - 622, 682, 688', 9);

INSERT INTO Requirements(specialization, description, credits)
VALUES('HCI', 'Total HCI Credits', 15);

INSERT INTO Requirements(specialization, description, credits)
VALUES('HCI', 'Programming', 6);

INSERT INTO Requirements(specialization, description, credits)
VALUES('HCI', 'Statistics', 3);

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Foundations' and r.specialization = 'MSI'
and c.title = 'SI 500 - Information in Social Systems: Collections, Flows, and Processing';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Foundations' and r.specialization = 'MSI'
and c.title = 'SI 501 - Contextual Inquiry and Project Management';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Foundations' and r.specialization = 'MSI'
and c.title = 'SI 502 - Networked Computing: Storage, Communication, and Processing';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 523 - Information and Control';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 530 - Principles and Management';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 534 - Theories of Social Influence';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 617 - Choice Architecture';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 626 - Management of Nonprofit Libraries and Information Services';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 627 - Managing the Information Technology Organization';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 638 - School Library Media Management';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 663 - Entrepreneurship in the Information Industry';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 544 - Introduction to Statistics and Data Analysis';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 562 - Microeconomics';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 563 - Game Theory';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 601 Data Manipulation';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 618 - Exploratory Data Analysis';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 622 - Needs Assessment and Usability Evaluation';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 623 - Research Methods for Information Professionals';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Management and Research' and r.specialization = 'MSI'
and c.title = 'SI 840 - Research Methods';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'PEP Credits' and r.specialization = 'MSI'
and c.title = 'SI 622 - Needs Assessment and Usability Evaluation';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'PEP Credits' and r.specialization = 'MSI'
and c.title = 'SI 501 - Contextual Inquiry and Project Management';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'PEP Credits' and r.specialization = 'MSI'
and c.title = 'SI 631 - Content Management Systems';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'PEP Credits' and r.specialization = 'MSI'
and c.title = 'SI 690 - Internship';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'PEP Credits' and r.specialization = 'MSI'
and c.title = 'SI 681 - Internship/Field Seminar';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Required - 622, 582, 588' and r.specialization = 'HCI'
and c.title = 'SI 622 - Needs Assessment and Usability Evaluation';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Required - 622, 582, 588' and r.specialization = 'HCI'
and c.title = 'SI 582 - Introduction to Interaction Design';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Required - 622, 582, 588' and r.specialization = 'HCI'
and c.title = 'SI 588 - Fundamentals of Human Behavior';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Programming' and r.specialization = 'HCI'
and c.title = 'SI 539 - Design of Complex Websites';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Programming' and r.specialization = 'HCI'
and c.title = 'SI 543 - Programming I (Java)';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Programming' and r.specialization = 'HCI'
and c.title = 'SI 664 - Database Application Design';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Statistics' and r.specialization = 'HCI'
and c.title = 'SI 544 - Introduction to Statistics and Data Analysis';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 582 - Introduction to Interaction Design';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 588 - Fundamentals of Human Behavior';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 622 - Needs Assessment and Usability Evaluation';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 520 - Graphic Design';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 529 - eCommunities: Analysis and Design of Online Interaction Environments';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 531 - Human Interaction in Information Retrieval';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 551 - Information-Seeking Behavior';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 561 - Natural Language Processing';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 583 - Recommender Systems';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 601 - Data Manipulation';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI - Personal Informatics Design';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 612 - Pervasive Interaction Design';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 618 - Exploratory Data Analysis';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 631 - Content Management Systems';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 649 - Information Visualization';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 658 - Information Architecture';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 664 - Database Application Design';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 686 - User-Generated Content';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 689 - Computer-Supported Cooperative Work';

INSERT INTO Fulfills(r_id, class_id)
SELECT r.r_id, c.class_id from Requirements r, Class c where r.description = 'Total HCI Credits' and r.specialization = 'HCI'
and c.title = 'SI 694 - Advanced Project and Social Computing Design';
