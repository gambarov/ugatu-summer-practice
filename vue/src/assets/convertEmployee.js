
export const convertEmployee = (arr) => {
    return arr.map((set) => {
        if (set.surname != null&&set.patronymic != null&&set.name != null) {
            set.employeeInitials = set.surname + " " + set.name[0] + "." + set.patronymic[0] + ".";

        }
        return set;
    })

}