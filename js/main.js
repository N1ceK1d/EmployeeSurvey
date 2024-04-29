function userAnswer(max_selected = 3) {
    let selected = 0;
    $('.btn').hide(100);
       
    $('.answers').on('click', (event) => {
        if(selected < max_selected) {
            if ($(event.target).hasClass('answer')) {
                $(event.target).remove();
                $('.selected_list').append(event.target.outerHTML);
                selected++;
            }
            buttonVisible();
        }
    });
    $('.selected_list').on('click', (event) => {
        if($(event.target).hasClass('answer')) {
            $('.answers').append(event.target.outerHTML);
            $(event.target).remove();
            selected--;
        }
        buttonVisible();
    })
    $('.submit_data').on('click', () => {
        $('.data-form .selected-items').html('');
        $('.selected_list .answer').map((index, element) => {
            $('.data-form .selected-items').append(`
            <div class='answer_item'>
                <input type='hidden' name='answer_id[]' value='${$(element).find(':first-child').val()}'/>
                <input type='hidden' name='answer_priority[]' value='${index+1}'/>
            </div>
            `);
            console.log(index + 1);  
        });
    })
};

function buttonVisible() {
    if($('.selected_list').children().length > 0) {
        $('.btn').show(100);
    } else {
        $('.btn').hide(100);
    }
}