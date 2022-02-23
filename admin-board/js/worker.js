/*
    this is just a terrible attempt to copy the course code from 
    each card and pass it to the modal's delete button
*/



var course=null;
const deleteAction = () => {
    if (course)
        window.location = "delete_course?id=" + course;
}

const deleteCourse = (code) => {
    course = (code)? code: '';
    $('#staticBackdrop').modal('show');
    $("#delete-btn")[0].onclick = deleteAction;
}