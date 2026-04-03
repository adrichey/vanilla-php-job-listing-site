# Vanilla Jobs
A vanilla PHP job site. This was a fun little side project, but _**it is in no way production ready**_. Please use this as a learning reference.

The application was built with PHP 8.5.4, Composer 2.9 (for PSR-4 routing), and MariaDB 10.11.16. You can see the table structure by diving into the `/docker/db/vanilla_jobs.sql` file.

## Running the application
I have included a docker container implementation for ease of use. It will populate the database, install our composer dependencies, and launch the application locally. To fire up things locally, please follow the steps below:
1. Download and install Docker. This will vary by system. [Linux](https://docs.docker.com/desktop/setup/install/linux/) | [Windows](https://docs.docker.com/desktop/setup/install/windows-install/) | [MacOS](https://docs.docker.com/desktop/setup/install/mac-install/)
2. Copy `.env.example` to `.env`. You shouldn't have to change anything if you are running the app using Docker.
3. Once Docker is installed, open up a terminal and run the following command:
`docker-compose up --build -d`
4. Once the application is built, you can view the application at [http://localhost:8000/](http://localhost:8000/)

You can take down the contain using the command: `docker-compose down`

Once you have built the application for the first time in step 2 above, you shouldn't need to rebuild it. You can bring the container back up using the following command: `docker-compose down`

## Acknowledgements
Header image "[Woman Scooping Ice Cream](https://www.pexels.com/photo/woman-scooping-ice-cream-25391582/)" by Viridiana Rivera is used under CC license.
