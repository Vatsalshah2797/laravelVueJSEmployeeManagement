<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Employee Listing</div>
                    <div class="card-body">
                        <table class="table table-bordered mt-4">
                            <thead>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Salary</th>
                            </thead>
                            <tbody v-if="employees.length">
                                <tr v-for="department in employees">
                                    <td v-if="department['employees'].length > 0">
                                        <table class="table">
                                            <tbody>
                                                <tr v-for="(employee,index) in department['employees']" :key="index">
                                                    <td> {{ employee.name }} </td>
                                                    <td> {{ department.name }} </td>
                                                    <td> <input type="text" name="salary" v-model="employee.salary" @change="updateEmployeeSalary(employee.id, employee.salary)" /> </td>
                                                </tr>
                                                <tr>
                                                    <td>Total Salary Of {{ department.name }} Department </td>
                                                    <td>{{ department.employees_sum_salary }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td> Total Salary Of All Department </td>
                                    <td>{{ total_department_salary }}</td> 
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>No Record Found.</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    
    export default {
        //Declare Variable
        data() {
            return {
                employees:[],
                api: import.meta.env.VITE_API_URL
            }
        },
        //Calculate all departments combined salary
        computed: {
            total_department_salary: function () {
                var sum = 0;
                if (this.employees.length > 0) {
                    this.employees.forEach(e => {
                        if (e.hasOwnProperty('employees_sum_salary')) {
                            sum += e.employees_sum_salary;
                        }
                    });
                }
                return sum;
            }
        },
        //Set Value for the department wise employee list :: Read Fetch All Employee List data
        mounted() {
            this.getDepartmentWiseEmployeesList();
        },
        //Perform action on operation like read, update salary on change of value 
        methods:{
            //Read Fetch Department Wise All Employees data :: API Call
            getDepartmentWiseEmployeesList() {
                this.axios.get(this.api+'/departments').then((response) => {
                    if (response.status === 200 && response.data.length > 0){
                        this.employees = response.data;
                    }
                });
            },
            //Update Employee salary on change of value :: API Call
            updateEmployeeSalary(id, amount) {
                if(id > 0) {
                    if (parseFloat(amount) > 0) {
                        let data = {'salary': parseFloat(amount)};
                        this.axios.put(this.api+'/employee/'+id, data).then((response) => {
                            //console.log(response.status);
                            //return false;
                            //rerender listing
                            if(response.status === 200) {
                                this.getDepartmentWiseEmployeesList();
                            } else {
                                alert('Something went wrong.'); 
                            }
                        });
                    } else {
                        alert('Please add valid amount.');
                    }
                } else {
                    alert('Something went wrong.');
                }
            }
        }
    }
</script>
