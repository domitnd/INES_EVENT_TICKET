# Page Map and Navigation Flow

This document describes the main pages of the INES Event Ticket Generator system and how users navigate between them.

---

## Public Pages

1. **Home Page**
   - Entry point of the application shows the available events and a navigation link the where to buy ticket.

2. **Register Ticket Page**
   - Attendee fills in registration form
   - On successful submission, a unique ticket code is generated
   - User is shown a confirmation message with the ticket code on Email

## Admin Pages

4. **Admin Login Page**
   - Event organizer logs in using credentials
   - Successful login redirects to the Admin Dashboard

5. **Admin Dashboard**
   - Displays total registered attendees
   - Displays total checked-in attendees
   - Shows recent ticket registrations
   - Provides navigation to Ticket List

6. **Ticket List Page**
   - Displays all registered tickets in a table
   - Each ticket has a link to view details

7. **Ticket Details Page**
   - Shows detailed information about a specific ticket
   - Allows the organizer to mark the ticket as checked-in
   - Checked-in tickets cannot be used again

---

## Navigation Flow Diagram (Textual)

Home
docs/
├── problem-statement.md
    ├── stakeholders.md
    ├── user-stories.md
    ├── scope-nfr.md
    └── page-map.md
├── admin-dashboard
├── checkout
└── Admin Login
└── create-event
├── earnings
└── edit-event
├── event
├──index
├──login-process
├──logout
├──manage-events
├──manage-organizers
├──my-events
├──organizer-dashboard
├──success
└──view-reports


This navigation flow ensures a clear separation between public users and administrators while supporting all required system features.