$(function(){
    //入力フォームを追加する
    $(".c_form-box__input-variable-length-box-add-btn").click(function(){
        //何番目のボタンかを取得
        let index = $(".c_form-box__input-variable-length-box-add-btn").index(this);
        //その日付に含まれるフォームの数を調べる
        let count = $(`.c_form-box__input-variable-length-box-wrapper:eq(${index}) > .c_form-box__input-variable-length-box`).length;
        //日付を取得
        let date = $(`input[name="workDate"]:eq(${index})`).val();
        if(count == 0){
            $(`.c_form-box__input-variable-length-box-wrapper:eq(${index}) > label`).after(`
                <div class="c_form-box__input-variable-length-box">
                    <i class="fas fa-times-circle"></i>
                    <input id="scope" class="width60" name="candidates[${date}][time][]" type="number" value="" placeholder="例）09:00ならば「0900」" required>
                    <p></p>
                </div>
            `);
        }
        else{
            $(`.c_form-box__input-variable-length-box-wrapper:eq(${index}) > .c_form-box__input-variable-length-box:eq(${count - 1})`).after(`
                <div class="c_form-box__input-variable-length-box">
                    <i class="fas fa-times-circle"></i>
                    <input id="scope" class="width60" name="candidates[${date}][time][]" type="number" value="" placeholder="例）09:00ならば「0900」" required>
                    <p></p>
                </div>
            `);
        }
    });

    //削除ボタン
    $('body').on('click', '.fa-times-circle' , function(){
        let index = $(".fa-times-circle").index(this);
        console.log(index);
        $(".c_form-box__input-variable-length-box").eq(index).remove();
    });
});