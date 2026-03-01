# Scope and Non-Functional Requirements

## In-Scope
The INES Event Ticket Generator system will include the following features:

- Home page with basic event information
- Attendee registration form
- Server-side generation of unique ticket codes
- Storage of attendee and ticket data in a MySQL database
- Public ticket lookup page using ticket code
- Admin login system
- Admin dashboard showing event statistics
- Ticket list and ticket details pages
- Server-side input validation and error handling
- MVC (Model-View-Controller) architecture with separation of concerns

---

## Out-of-Scope
The following features are not included in this project:

- Online payments or mobile money integration
- QR code generation or scanning
- Email or SMS ticket delivery
- Multiple event management
- Role-based access control beyond basic admin login
- Third-party APIs or external libraries

---

## Non-Functional Requirements (NFRs)
The system must satisfy the following non-functional requirements:

- The application must be built using HTML, CSS,JavaScript, PHP, and MySQLi
- Prepared statements must be used to prevent SQL injection
- The system must follow MVC architecture
- Pages should load within a reasonable time on standard internet connections
- The interface must be responsive on mobile and desktop devices
- User inputs must be validated on both client-side and server-side
- The system must be hosted on a free PHP-supported hosting platform
- Source code must be version-controlled using Git and GitHub