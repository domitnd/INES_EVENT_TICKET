# INES Event Ticket Generator 🎟️

A full-stack web application for managing event registration, ticket generation, and check-in, designed for INES organizers and students.

---

## Overview

Event organizers and students often face:

- Slow registration and ticket generation  
- Duplicate or missing tickets  
- Manual attendance tracking  
- Confusion at check-in  

This app automates ticket registration, provides a dashboard, and generates unique ticket codes to simplify event management.

---

## Features

- **Attendee Registration:** Collect attendee information with server-side validation  
- **Ticket Generation:** Unique ticket codes for every attendee  
- **Ticket Lookup:** Public page to verify tickets  
- **Admin Dashboard:** View total registered, total checked-in  
- **Check-in:** Mark tickets as used  
- **MVC Architecture:** Clean separation of concerns  
- **Responsive Design:** Mobile & desktop friendly  

---

## Tech Stack

- **Frontend:** HTML, CSS, Vanilla JS  
- **Backend:** PHP (MVC, MySQLi)  
- **Database:** MySQL  
- **Version Control:** Git / GitHub  
- **Deployment:** InfinityFree  

---

## Project Structure


app/
├── controllers/ # App logic
├── models/ # Database operations
├── views/ # HTML/PHP templates
└── config/ # Database config

public/
└── index.php # Entry point / routing

assets/
├── css/ # Styles
├── js/ # Scripts
└── images/ # Images

config/
├──database.php

docs/
├── problem-statement.md
├── user-stories.md
├── scope-nfr.md
├── page-map.md
└── testing.md

README.md


---

## Setup & Deployment

1. **Clone the repository**  
```bash
git clone https://github.com/<username>/ines-event-ticket.git
cd ines-event-ticket

Database Setup

Create a MySQL database

Import database/schema.sql (and optionally seed.sql)

Update app/config/database.php with database credentials

Run Locally

Use XAMPP / WAMP / MAMP

Access via http://localhost/ines-event-ticket/

Deploy on InfinityFree

Upload all project files to htdocs via File Manager or FTP

Configure MySQL database and import schema

Update app/config/database.php with remote DB credentials

Access the live site using your subdomain

Hosted Demo: https://ines-event-hub.infinityfreeapp.com

Team & Roles
Role	Name	Responsibility
Product Planner & Documentation	[Your Name]	Problem statement, user stories, scope & docs
UI/UX Designer	[Member 2]	Wireframes, design rules
HTML Engineer	[Member 3]	HTML structure & templates
CSS Engineer	[Member 4]	Styles & responsiveness
JS Engineer	[Member 5]	Interactivity & client validation
Backend Engineer	[Member 6]	PHP MVC, CRUD, server validation
DB & Deployment Engineer	[Member 7]	Database, Git, hosting setup
AI Usage

As required by the assignment, AI was used as a tool to assist planning, documentation, and problem-solving.

Questions / Prompts Asked

Guidance on Role 1 tasks: problem statement, stakeholders, user stories, scope, page map

Help writing Problem Statement & Stakeholders for INES Event Ticket Generator

Writing 6 User Stories with acceptance criteria

Writing Scope, Out-of-Scope, and Non-Functional Requirements

Creating a Page Map / Navigation Flow

Assistance with README.md structure for the project

Troubleshooting CSS changes not reflecting after Git pull

Deployment guidance for InfinityFree hosting

Structuring a lecturer-friendly README

Integrating AI usage section into README

What was done / Learned

Converted vague assignment instructions into clear problem statements and user stories

Learned to define project scope and NFRs properly

Produced a page navigation map for all app pages

Learned best practices for hosting PHP + MySQL projects on InfinityFree

Learned how to structure a clean, professional README for submission

Learned how to document AI usage transparently for lecturer requirements

Testing

Documented in docs/testing.md with at least 10 test cases:

Ticket registration & validation

Unique ticket code generation

Admin login & dashboard metrics

Ticket lookup & check-in

Client & server-side input validation

Notes

All SQL queries use prepared statements to prevent SQL injection

MVC pattern is fully maintained

Fully responsive design for mobile and desktop