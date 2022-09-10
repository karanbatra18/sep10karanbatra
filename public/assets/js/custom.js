$(document).ready(function() {
    // Remove the subject from form for submission
    $(document).on('click','.remove_subject',function(){
        $(this).closest('.subject_group').remove();
    });

    // Add new subject on dom
    $(document).on('click','.add_more',function(){
        var newSubject = '<div class="subject_group">';
        newSubject += '<input type="text" class="form-control input_style" name="subjects[name][]" value="" placeholder="Subject Name">';
        newSubject += '<input type="text" class="form-control input_style" name="subjects[marks][]" value="" placeholder="Marks">';
        newSubject += '<input type="text" class="form-control input_style" name="subjects[grade][]" value="" placeholder="Grade">';
        newSubject += '<a href="javascript:;" class="remove_subject">Delete This Subject</a>';
        newSubject += '</div>';
        $('.subject_block').append(newSubject);
    });
});
