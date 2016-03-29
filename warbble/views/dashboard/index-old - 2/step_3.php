<div class="step step_3">
    <h1>Your page design</h1>
    <h4>Please pick a design that you like. Don’t worry if its not perfect, we’ll work with you to make sure that it is.</h4>

    <div class="designs carousel">
        <?php $this->view('dashboard/index/_designs', array(
            'products' => $products
        )) ?>
    </div>
    <div class="actions">
        <button type="button" class="step-btn previous_step2_submit">Previous Step</button>
        <button type="button" class="step-btn step3_submit">Next Step</button>
    </div>
</div>