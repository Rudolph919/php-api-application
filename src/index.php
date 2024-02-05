<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue.js & PHP Subscriber App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div id="app" class="container">
        <h1>Subscriber Registration</h1>
        <form @submit.prevent="submitSubscriber" class="row mb-3">
            <div class="col-md-6 form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="subscriber.email" required class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="subscriber.name" required class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" v-model="subscriber.last_name" required class="form-control">
            </div>
            <div class="col-md-6 form-group">
                <label for="status">Status:</label>
                <select id="status" v-model="subscriber.status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>

        <h2>Subscribers</h2>
        <div v-if="subscribers.length > 0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="subscriber in paginatedSubscribers" :key="subscriber.id">
                        <td>{{ subscriber.email }}</td>
                        <td>{{ subscriber.name }}</td>
                        <td>{{ subscriber.last_name }}</td>
                        <td>{{ subscriber.status }}</td>
                    </tr>
                </tbody>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" v-if="currentPage > 1">
                        <a class="page-link" href="#" @click="prevPage">Previous</a>
                    </li>
                    <li class="page-item" v-for="pageNum in pageCount" :key="pageNum">
                        <a class="page-link" href="#" :class="{ active: pageNum === currentPage }">{{ pageNum }}</a>
                    </li>
                    <li class="page-item" v-if="currentPage < pageCount">
                        <a class="page-link" href="#" @click="nextPage">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div v-else class="text-center">
            No subscribers found.
        </div>
    </div>

    <script>
      const app = new Vue({
        el: '#app',
          data() {
            return {
              subscriber: {
                email: '',
                name: '',
                last_name: '',
                status: 'active',
              },
              subscribers: [],
              currentPage: 1,
              pageCount: 1,
            };
          },

          mounted() {
            this.fetchSubscribers();
          },
          methods: {
            fetchSubscribers() {
              axios.get('/API/index.php?action=getAllSubscribers')
                .then(response => {
                  this.subscribers = response.data;
                  this.pageCount = Math.ceil(this.subscribers.length / 10);
                })
                .catch(error => {
                  console.error(error);
                  // TODO: Handle errors appropriately
                });
            },
            submitSubscriber() {
              axios.post('/API/index.php', {
                action: 'registerSubscriber',
                subscriber: this.subscriber,
              })
                .then(response => {
                  this.subscriber = { // Reset form fields
                    email: '',
                    name: '',
                    last_name: '',
                    status: 'active',
                  };
                  this.fetchSubscribers(); // Update subscriber list
                })
                .catch(error => {
                  console.error(error);
                  // TODO: Handle errors appropriately
                });
            },
            prevPage() {
              if (this.currentPage > 1) {
                this.currentPage--;
              }
            },
            nextPage() {
              if (this.currentPage < this.pageCount) {
                this.currentPage++;
              }
            },
          },
          computed: {
            paginatedSubscribers() {
              const startIndex = (this.currentPage - 1) * 10;
              const endIndex = startIndex + 10;
              return this.subscribers.slice(startIndex, endIndex);
            },
          },
        });
    </script>
</body>
</html>
