<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Employee Listing</div>
                    <div class="card-body">
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr colspan="3">
                                    <th width="33%">Employee</th>
                                    <th width="33%">Department</th>
                                    <th width="33%">Salary</th>
                                </tr>
                            </thead>
                            <tbody v-if="employees.length">
                                <tr v-for="department in employees">
                                    <td colspan="3" v-if="department['employees'].length > 0">
                                        <table class="table">
                                            <tbody>
                                                <tr colspan="3" v-for="(employee,index) in department['employees']" :key="index">
                                                    <td width="33%"> {{ employee.name }} </td>
                                                    <td width="33%"> {{ department.name }} </td>
                                                    <td width="33%"> <input type="text" name="salary" v-model="employee.salary" @change="updateEmployeeSalary(employee.id, employee.salary)" /> </td>
                                                </tr>
                                                <tr >
                                                    <td colspan="2"><b>Total Salary Of {{ department.name }} Department </b></td>
                                                    <td><b>{{ department.employees_sum_salary.toFixed(2) }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"> <b>Total Salary Of All Department</b> </td>
                                    <td class="text-success"><b>{{ total_department_salary }}</b></td> 
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="3" align="center" class="text-danger">
                                        <b >No Record Found.</b>
                                    </td>
                                </tr>
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
                return sum.toFixed(2);
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
