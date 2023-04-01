<template>
    <div>
        <div class="search-container">
            <input type="text" v-model="searchQuery" placeholder="Search by name">
            <div>
                <label>Type:</label>
                <select v-model="filters.type">
                    <option value="">All</option>
                    <option v-for="type in propertyTypes" :key="type.id"
                    :value="type.id">{{ type.name }}</option>
                </select>
            </div>
            <div>
                <label>User:</label>
                <select v-model="filters.user">
                    <option value="">All</option>
                    <option v-for="user in users" :key="user.id"
                    :value="user.id">{{ user.name }}</option>
                </select>
            </div>
            <div>
                <label>Rented from:</label>
                <input type="date" v-model="filters.rentedFrom">
            </div>
            <div>
                <label>Rented to:</label>
                <input type="date" v-model="filters.rentedTo">
            </div>
        </div>
        <div class="search-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Rented Months</th>
                        <th>Currently Rented?</th>
                        <th>User</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="property in filteredProperties" :key="property.id">
                        <td>{{ property.name }}</td>
                        <td>{{ getType(property.typeId).name }}</td>
                        <td>{{ rentedMonths(property.rentedFrom, property.rentedTo) }}</td>
                        <td>{{ isCurrentlyRented(property) ? 'Yes' : 'No' }}</td>
                        <td>{{ getUser(property.userId)?.name }}</td>
                        <td>{{ formatDate(property.rentedFrom) }}</td>
                        <td>{{ formatDate(property.rentedTo) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { users, propertyTypes, properties } from '@/mocks/api';
/* I created a unique filter for the table that includes the different options.
In the formatDate method I used the option to loLocaleString because it's scalable
and it can be obtained from the browser.
When getting the parameters I thought about the possibility of multiple parameters
but I didn't manage to use a I couldn't use a dynamic variable so I had to use a switch case.
I could improve the code by adding Router and moment but I decided to keep the code
as simple as possible.
*/
export default {
    name: 'App',
    data: () => ({
        users,
        propertyTypes,
        properties,
        filters: {
            type: '',
            user: '',
            rentedFrom: '',
            rentedTo: '',
        },
        searchQuery: '',
    }),
    computed: {
        filteredProperties() {
            const filtered = this.properties.filter((property) => (
                property.name.toLowerCase().includes(this.searchQuery.toLowerCase())
                && (!this.filters.type || property.typeId === this.filters.type)
                && (!this.filters.user || property.userId === this.filters.user)
                && (!this.filters.rentedFrom || new Date(property.rentedFrom)
                >= new Date(this.filters.rentedFrom))
                && (!this.filters.rentedTo || new Date(property.rentedTo)
                    <= new Date(this.filters.rentedTo))));
            return filtered;
        },
    },
    methods: {
        formatDate(date) {
            if (date) {
                return new Date(date).toLocaleDateString('es-ES');
            }
            return '-';
        },
        getType(id) {
            return this.propertyTypes.find((propertyType) => propertyType.id === id);
        },
        getUser(id) {
            return this.users.find((user) => user.id === id);
        },
        rentedMonths(startDate, endDate) {
            if (startDate) {
                const start = new Date(startDate);
                let end = new Date();
                if (endDate) {
                    end = new Date(endDate);
                }
                const yearDiff = end.getFullYear() - start.getFullYear();
                const monthDiff = end.getMonth() - start.getMonth();
                return yearDiff * 12 + monthDiff;
            }
            return 0;
        },
        isCurrentlyRented(property) {
            if (property.rentedFrom && !property.rentedTo) {
                return true;
            }
            return false;
        },
    },
    created() {
        const params = window.location.search.substring(1).split('&');
        if (params[0] !== '') {
            /* eslint-disable-next-line no-plusplus */
            for (let i = 0; i < params.length; i++) {
                const param = params[i].split('=');
                switch (param[0]) {
                    case 'user':
                        this.filters.user = parseInt(param[1], 10);
                        break;
                    case 'type':
                        this.filters.type = parseInt(param[1], 10);
                        break;
                    case 'rentedFrom':
                        /* eslint-disable-next-line prefer-destructuring */
                        this.filters.rentedFrom = param[1];
                        break;
                    case 'rentedTo':
                        /* eslint-disable-next-line prefer-destructuring */
                        this.filters.rentedTo = param[1];
                        break;
                    default:
                        break;
                }
            }
        }
    },
};
</script>
<style>
@import url("../css/estilos.css");
</style>
