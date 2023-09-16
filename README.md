Sanjeevani Medics Web Application:-
--------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------

Sanjeevani Medics is a web and mobile application designed to assist doctors and patients in managing their health records, accessing medical information, and connecting both remotely by means of consultancy. This web application was developed by Mohammad Gaush Igtekhar, Vivek Verma, and Harshit Soni in their Final Year Project. My role in this web application is to develop the API for Patient and Doctor Authentication and also for the Appointment Booking API for the Patient. This repository contains the appointment and authentication API.

Frontend of the web application: https://sanjeevani-medics.web.app/#/dashboard

Tech Stack For API:- Mysql, Laravel, PHP.

The two API's are:-

1. Authentication API Path:- app/Http/Controllers/AuthController.php

--------------------

	a. Contain registerDoctor method which is used to register the doctor and save their details in database.

    b. registerDoctor uses Sanctum token based authentication to authenticate the doctor data.

	b. Contain loginDoctor method to Login the doctor by checking their credentials like email and password.

    c. It has registerPatient method which is used to register the patient and save their details in database. It also uses Sanctum token generation.

    d. loginPatient is used to login the patient by checking their credentials.

    e. logout method is used to logout the doctor as well as the patient.

2. Appointment Booking API path:- app/Http/Controllers/AppointmentController.php

----------------------

	a. A class AppointmentController which is used to perform CRUD operations on appointment booking.

    b. store method which creates an appointment after authenticating the patient this performs CREAT operation.

    c. show method is used to show the booked appointment details to the patient and it performs READ operation.

    d. update method is used to update the appointment record.

    e. destroy method deletes the appointment record from the database.
    
