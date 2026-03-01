# User Stories and Acceptance Criteria

## User Story 1: Event Registration
As an attendee, I want to register for an event online so that I can secure my place without going to the venue.

### Acceptance Criteria
- Registration form collects full name, email, and phone number
- Required fields cannot be empty
- Successful submission saves data to the database
- User receives a confirmation message after registration

## User Story 2: Ticket Code Generation
As an attendee, I want to receive a unique ticket code so that I can present it during event check-in.

### Acceptance Criteria
- Ticket code is generated on the server
- Ticket code is unique for every registration
- Ticket code is stored in the database
- Ticket code is displayed to the user after registration


## User Story 3: Ticket Lookup
As an attendee, I want to look up my ticket using my ticket code so that I can confirm my registration status.

### Acceptance Criteria
- Public ticket lookup page exists
- Valid ticket code displays attendee details
- Invalid ticket code shows a clear error message


## User Story 4: Admin Authentication
As an event organizer, I want to log in to the system so that only authorized users can manage event data.

### Acceptance Criteria
- Login requires a username and password
- Incorrect credentials are rejected
- Successful login redirects to the admin dashboard


## User Story 5: Ticket Check-In
As an event organizer, I want to mark tickets as checked in so that attendance is tracked accurately.

### Acceptance Criteria
- Organizer can search for a ticket using the ticket code
- Ticket status changes from "unused" to "used"
- A ticket marked as used cannot be checked in again


## User Story 6: Dashboard Overview
As an event organizer, I want to view event statistics on a dashboard so that I can monitor registrations and attendance.

### Acceptance Criteria
- Dashboard shows total registered attendees
- Dashboard shows total checked-in attendees
- Recent registrations are displayed