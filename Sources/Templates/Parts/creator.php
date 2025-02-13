<div id="js-modal" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">

    <header class="modal-card-head">
      <p class="modal-card-title">Create a New Issue</p>
      <button class="is-large delete" aria-label="close"></button>
    </header>

    <form name="new_issue" method="POST">
      <section class="modal-card-body">

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="question">Question</label>
        </div>
        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="question" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select>
                <option value="admin">🟣 Administrative</option>
                <option value="conflict">🔴 Conflict</option>
                <option value="economy">🟢 Economics</option>
                <option value="sports">🟡 Sports</option>
                <option value="sapphire">🔵 Sapphire</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label">Context</label>
        </div>
        <div class="field-body">
          <div class="field">
            <textarea class="textarea is-info" placeholder="Explain more about the context and premise of the question."></textarea>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" id="theme_1">
        <div class="field-label is-normal">
          <label class="label" for="question">Option 1</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="option_1" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_1" name="theme_1">

                <optgroup label="Blue Themes">
                  <?php foreach ($blues_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Red Themes">
                  <?php foreach ($reds_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Green Themes">
                  <?php foreach ($greens_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Yellow Themes">
                  <?php foreach ($yellows_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Purple Themes">
                  <?php foreach ($purples_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

              </select>
            </div>
          </div>
        </div>
      </div>


      <div class="field is-horizontal" id="theme_2">
        <div class="field-label is-normal">
          <label class="label" for="question">Option 2</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="option_2" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_2" name="theme_2">

                <optgroup label="Blue Themes">
                  <?php foreach ($blues_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Red Themes">
                  <?php foreach ($reds_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Green Themes">
                  <?php foreach ($greens_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Yellow Themes">
                  <?php foreach ($yellows_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Purple Themes">
                  <?php foreach ($purples_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" id="theme_3">
        <div class="field-label is-normal">
          <label class="label" for="question">Option 3</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="option_3" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_3" name="theme_3">

                <optgroup label="Blue Themes">
                  <?php foreach ($blues_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Red Themes">
                  <?php foreach ($reds_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Green Themes">
                  <?php foreach ($greens_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Yellow Themes">
                  <?php foreach ($yellows_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Purple Themes">
                  <?php foreach ($purples_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" id="theme_4">
        <div class="field-label is-normal">
          <label class="label" for="question">Option 4</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="option_4" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_4" name="theme_4">

                <optgroup label="Blue Themes">
                  <?php foreach ($blues_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Red Themes">
                  <?php foreach ($reds_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Green Themes">
                  <?php foreach ($greens_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Yellow Themes">
                  <?php foreach ($yellows_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Purple Themes">
                  <?php foreach ($purples_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" id="theme_5">
        <div class="field-label is-normal">
          <label class="label" for="question">Option 5</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="option_5" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_5" name="theme_5">

                <optgroup label="Blue Themes">
                  <?php foreach ($blues_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Red Themes">
                  <?php foreach ($reds_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Green Themes">
                  <?php foreach ($greens_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Yellow Themes">
                  <?php foreach ($yellows_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

                <optgroup label="Purple Themes">
                  <?php foreach ($purples_lib as $colour): ?>
                  <option value="<?=$colour?>"><?=$colour?></option>
                  <?php endforeach; ?>
                </optgroup>

              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" id="theme_4">
        <div class="field-label is-normal">
          <label class="label" for="question">Betting Ends</label>
        </div>
        <div class="field-body">
          <div class="field">
            <input type="date" id="start" name="date_start" value="<?=date("Y-m-d", time())?>" min="<?=date("Y-m-d", time())?>"/>
            <input type="time" id="start" name="time_start"/>
          </div>
        </div>
      </div>

      </section>
      <footer class="modal-card-foot">
        <div class="buttons">
          <input type="submit" value="Send it" class="button is-success">
        </div>
      </footer>
    </form>
  </div>
</div>