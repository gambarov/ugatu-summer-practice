
export const convertEmployee = (arr) => {
    return arr.map((set) => {
        if (set.surname != null&&set.patronymic != null&&set.name != null) {
            set.employeeInitials = set.surname + " " + set.name[0] + "." + set.patronymic[0] + ".";

        }
        return set;
    })

}
export const convertEmployeeInArray = (arr) => {
    return arr.map((set) => {
        if (set.employee.surname != null&&set.employee.patronymic != null&&set.employee.name != null) {
            set.employee.employeeInitials = set.employee.surname + " " + set.employee.name[0] + "." + set.employee.patronymic[0] + ".";

        }
        return set;
    })

}