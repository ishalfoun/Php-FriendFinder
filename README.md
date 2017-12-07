# Final Project: Dawson Student Friend Finder

## Members
* [@theoathomas - Theodore Acco-Thomas](https://github.com/theoathomas)
* [@ishalfoun - Issak Shalfoun](https://github.com/ishalfoun)
* [@jacobr98 - Jacob Riendeau](https://github.com/jacobr98)

## Project Overview

**DangerousClub2** is a Laravel website hosted on Heroku that functions as a friend finder based on common breaks, as well as a registration app for registering for courses.

## Specifications

- [X] All functionality is only available to authenticated users
- [X] The home (index) page shows the users which courses they have chosen, and their confirmed friends (paginated). Indicate if there are pending received friend requests.
- [X] Manage friends: page(s) that show all the user’s friends with a status (confirmed friends, friend request sent, friend request received). It allows searching for new friends and allows the user to send a friend request, accept or reject received friend requests, and to unfriend friends. 
- [X] Manage courses: these page(s) allow searching for courses and allow the user to register for a new course / drop an existing course
- [X] Find confirmed friends with matching free break times between 10 am and 5 pm
- [X] When a new user registers, they must provide basic information such as first name, last name, email address (used as the key), password, program 
- [X] The friends’ management page(s) allow logged in users to search for new friends based on keyword search within the users’ name. Display the matching users in paginated pages. Show only the users’ first and last name and program.
- [X] The friends’ management page(s) show all the friends, with their status (confirmed, request sent, request received). If the user accepts a received friend request, change the status to confirmed. If the user deletes any friend (regardless of status), delete the entry from the database. NOTE: the “rejected” friend is not necessarily notified. You can add a “notification” feature if time permits, but it is optional.
- [X] The course management page(s) allow logged in users to see the courses for which they have registered. The user can delete a course (i.e., drop a course). They can also search for other courses (based on keywords found in the course number, title or teacher. They can register for a new course (not the ones for which they are already registered)
- [X] The free break page allows the user to find confirmed friends with breaks at the same time as the selected entry (day, start and end time).
- [X] JSON web API: the web API responds to http queries from the Android application with JSON messages, detailed at GitHub site.

The Web API used by your Android program is detailed in the GitHub site. It must support the following requests.
- [X] Read request (GET) to get friends on break at given day time start/end
- [X] Read request (GET) to retrieve where a friend is at given day time (course name and section, or free)
- [X] Read request (GET) to retrieve friends in a given class
- [X] Read request (GET) to retrieve all friends

Your final project must be pushed onto Heroku. I will mark the master branch of your team’s GitHub repository.

Grading
Part of your grade will reflect how you are able to organize your work and advance during the time that has been allocated. To that end, I have created teams and private repositories on GitHub, and large portion of your individual grade will be based on your commits and commit messages. Procrastinators will be penalized, regardless of the final result.  Please be prepared to attend your scheduled lab session for spot checks.


