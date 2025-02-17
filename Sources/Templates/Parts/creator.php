<div id="js-modal" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">

    <header class="modal-card-head">
      <p class="modal-card-title">Create a New Issue</p>
      <button class="is-large delete" aria-label="close"></button>
    </header>

    <form method="POST">
      <section class="modal-card-body">

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="question">Question</label>
        </div>
        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="new_issue[question]" type="text">
          </div>
          <div class="field">
            <div class="select is-info">
              <select name="new_issue[category]">
                <option value="admin">🟣 Administrative</option>
                <option value="conflict">🔴 Conflict</option>
                <option value="economics">🟢 Economics</option>
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
            <textarea name="new_issue[context]" class="textarea is-info" placeholder="Explain more about the context and premise of the question."></textarea>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" id="theme_1">
        <div class="field-label is-normal">
          <label class="label" for="new_issue[options][0][text]">Option 1</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="new_issue[options][0][text]" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_1" name="new_issue[options][0][colour]">

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
          <label class="label" for="new_issue[options][1][text]">Option 2</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="new_issue[options][1][text]" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_2" name="new_issue[options][1][colour]">

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
          <label class="label" for="new_issue[options][2][text]">Option 3</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="new_issue[options][2][text]" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_3" name="new_issue[options][2][colour]">

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
          <label class="label" for="new_issue[options][3][text]">Option 4</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="new_issue[options][3][text]" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_4" name="new_issue[options][3][colour]">

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
          <label class="label" for="new_issue[options][4][text]">Option 5</label>
        </div>

        <div class="field-body">
          <div class="field">
            <input class="input is-info" name="new_issue[options][4][text]" type="text">
          </div>
          <div class="field">
            <div name="category" class="select is-info">
              <select id="selector_5" name="new_issue[options][4][colour]">

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

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="new_issue[date_end]">Betting Ends</label>
        </div>
        <div class="field-body">
          <div class="field">
            <input type="date" name="new_issue[date_end]" value="<?=date("Y-m-d", time())?>" min="<?=date("Y-m-d", time())?>"/>
            <input type="time" name="new_issue[time_end]"/>
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