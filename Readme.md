## Steps to spin the application up locally

1. Make sure you have Docker Desktop installed on your local machine.
2. Make sure the repository has been cloned to a directory on your local machine.
3. Open a terminal window where you can interact with Docker.
4. Make sure you are in the root directory of the repository.
5. Build the docker images by running the following command:
```docker-compose build```

6. Run the docker images by executing the following command:
```docker-compose up -d```

7. Make sure to execute the SQL script to create the subscriber table. It can be found in the root folder of the project.
8. Open your browser and navigate to http://localhost:8080
