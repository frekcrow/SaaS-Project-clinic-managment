# Atlas SaaS - Product Requirements Document (PRD)

## 1. Dashboard (Overview)
* **Quick Actions:** Buttons for "Add Patient" and "Book Appointment".
* **Analytics:** Monthly visit statistics, interactive financial charts (Income insights with up/down trends).
* **Today's Overview:** Mini-table for today's appointments and total count of today's patients.
* **Global Search:** A floating search bar to find patients or sections across the system.
* **Live Consultation Counter:** A timer showing the current patient inside the doctor's room. Started and ended manually by the doctor.
* **Omnichannel Footer:** 
  * **Calls/Messages:** Integration with WhatsApp, Telegram, and Messenger. Shows a log of answered (green check) and missed (red cross) communications.
  * Includes 'Info' button for caller details (Platform, Date, Name).
  * Ability to reply directly from the system via text/media.
  * Contacts are saved in the background for bulk broadcasting.
* **Specialized Counters:** Count of patients needing surgery, and count of daily treatment sessions.

## 2. Patients Register (CRM)
* **Secretary View (Add Patient):** Fields: Full Name, DOB, Allergies, Phone, Chronic Diseases, Regular Medications, Doctor Name, Reason for Visit, Onset of Symptoms.
* **Doctor View (Medical File):** 
  * Specialized fields: Diagnosis, Prescription, Lab Tests required.
  * Attachments: Upload images for lab results or X-rays.
  * Actions: Print prescription only, Export/Share patient file as PDF, Save changes.
* **Multi-visit Logic:** If a patient visits multiple times, the doctor clicks "Create New Diagnostic File". Each visit is logged chronologically with its specific date and medical details.
* **Export:** Ability to export the entire patient register to a local Excel (.xlsx) file.

## 3. Appointments Scheduling
* **Booking Modal:** Fields: Patient Name, Phone, Doctor Name, Date & Time, Consultation/Session Price.
* **Status Tracking:** Pending (default), Completed, Cancelled.
* **Dynamic Countdown:** A timer showing days remaining. On the day of the appointment, it switches to hours/minutes. If missed, it shows a red 'X'. The secretary can manually override this if the patient is late.
* **Financial Automation:** When an appointment status is changed to "Completed", the system automatically adds the fee to the total revenue shown in the dashboard.
* **Communication:** Direct buttons to message or call the patient via social platforms or local SIM.

## 4. Accounting & Billing
* **Ledger View:** Lists patient names, amount paid (consultation vs. session), phone, date, and time.
* **Smart Receipts:** A popup dynamic receipt ready for printing. Includes Clinic Name, Patient Name, Date/Time, and itemized billing.
* **Toggle View:** Option to print a specific visit's receipt OR the entire financial history of the patient.
* **Filters:** Filter financial records by Today, Week, Month, or Year.

## 5. Template Builder
* **Customization:** A UI to design and edit the layout of Prescriptions and Financial Receipts.
* **Editable Elements:** Colors, Clinic Name, Logo, Address, Phone Number. Each template type (Prescription vs. Receipt) operates independently.

## 6. System Settings
* **Profile:** Doctor's Name, Photo, and Clinic Name.
* **Legal:** Privacy Policy.
* **Support:** Support account links.
* **App Version:** Current system version.
* **Broadcasting:** A bulk-messaging tool to send promotional messages to all saved contacts across linked social platforms.
* **Account Management:** Logout and Delete Account options.
