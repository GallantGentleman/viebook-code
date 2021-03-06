<?php
use yii\helpers\Html;

$url = Yii::$app->request->baseUrl;

$readReviewButton = <<<JS

jQuery('.review_text').click(function() {
    var id = jQuery(this).data('id');
    $.ajax({
       url: "$url?r=review/ajax&id=$book->id",
       type: 'GET',
       data: {
           review_id: id,
       },
       success: function (data) {
          var review = JSON.parse(data);
          $('.modal-content').html(review.text);
          $('.review_modal').modal('show');
       }
  });
});

JS;

$this->registerJs($readReviewButton);

?>

<div class="modal fade review_modal" tabindex="-1" role="dialog" aria-labelledby="read_this_review">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 10px 30px;">
        <center><img src="images/loader.gif"></center>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="book">
            <div class="name">
                <h3 style="margin: 0; text-align: center;"><?= $book->name ?></h3>
            </div>
            <div class="image" style="text-align: center;">
                <img src="images/books/<?= $book->image ?>" width="200" height="315">
                <br>
                <br>
                <?= Html::a("Написать рецензию", ['review/write', 'bookid' => $book->id], ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <h3 class="text-center">Рецензии</h3>
        <br>
        <?php if ($book->reviews): ?>
            <div class="book_reviews">
                <?php foreach($book->reviews as $review): ?>
                    <div class="single_review">
                        <div class="status_line">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <?= Html::a($review->author['username'], ['user/view', 'id' => $review->author['id']]) ?>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <span class="glyphicon glyphicon-eye-open"></span>
                            <?= $review->views ?>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <span class="glyphicon glyphicon-calendar"></span>
                            <?= date("d M Y", $review->created_at) ?>
                        </div>
                        <div class="review_text" data-id="<?= $review->id ?>">
                            <?php $text = intval(strlen($review->text) / 3) ?>
                            <?= mb_substr($review->text, 0, $text, "utf-8") ?>...
                        </div>
                        <br>
                        <div class="go_read">
                            <?= Html::a("Читать дальше", ['review/view', 'id' => $review->id], ['class' => 'btn btn-default pull-right read_this_review']); ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>

            <div class="text-center">
                Нет ни одной рецензии. Нажмите кнопку слева, чтобы написать.
            </div>

        <?php endif; ?>
    </div>
</div>
