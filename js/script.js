(function($, window, document) {
  function updateStreetList(value) {
    $('.phonebook-form__city-input').val('');
    $.ajax({
        url: 'db_get_streets_list.php',
        method: 'post',
        data: {
          city_id: value
        },
        dataType: 'json'
      })
      .done(function(json) {
        var $streetSelect = $('.phonebook-form__street-select');
        $streetSelect.html('<option>Выберите улицу</option>');
        if (json.length > 0) {
          var str = '';
          for (var i = 0; i < json.length; i++) {
            str += '<option value="' + json[i].id +'">' + json[i].street_name + '</option>';
          }
          $streetSelect.append(str);
          if ($streetSelect.attr('data-street-id')) {
            $streetSelect.val($streetSelect.attr('data-street-id'));
          }
        }
      });
  }
  function updateRecordsList() {
    $.ajax({
      url: 'db_get_users_data.php',
      dataType: 'json'
    })
      .done(function(json) {
        var str = '';
        for (var i = 0; i < json.length; i++) {
          str += '<div class="phonebook__row" data-record-id="' + json[i].id +'">' +
            '<div class="phonebook__row__item">' + json[i].last_name + '</div>' +
            '<div class="phonebook__row__item">' + json[i].first_name + '</div>' +
            '<div class="phonebook__row__item">' + json[i].second_name + '</div>' +
            '<div class="phonebook__row__item">' + json[i].city_name + '</div>' +
            '<div class="phonebook__row__item">' + json[i].street_name + '</div>' +
            '<div class="phonebook__row__item">' + json[i].birth_date + '</div>' +
            '<div class="phonebook__row__item phonebook__row__item--phone">' + json[i].phone_number + '</div>' +
            '<div class="phonebook__row__item"><button class="phonebook__delete-record">X</button>' +
            '<a href="edit.php?record_id=' + json[i].id + '" class="phonebook__update-record">Ред.</a></div></div>';
        }
        $('.phonebook__body').html(str);
        deleteRecordInit();
      })
  }
  function deleteRecordInit() {
    $('.phonebook__row').on('click', '.phonebook__delete-record', function() {
      $.ajax({
        url: 'db_delete_user_record.php',
        method: 'post',
        data: {
          record_id: $(this).closest('.phonebook__row').attr('data-record-id')
        },
        dataType: 'json'
      })
        .done(function(json) {
          if (json == 1) {
            updateRecordsList();
          }
        })
    });
  }
  $(function() {
    updateRecordsList();
    $('#datepicker').datepicker({
      dateFormat: "dd.mm.yy"
    });
    var $phoneInput = $('.phonebook-form__phone-input');
    var updateButton = $('.phonebook-form__update');
    $phoneInput.mask('+7 999 999-99-99', {
      placeholder: '+7 ___ ___-__-__'
    });

    // Get cities for autocomplete field
    var $citiesInput = $('#cities_input');
    var selectedCityID;
    $citiesInput.autocomplete({
      minLength: 0,
      source: function(request, response) {
        $.ajax({
            url: 'db_get_cities_list.php',
            method: 'post',
            data: {
              word: request.term
            },
            dataType: 'json'
          })
          .done(function(json) {
            var cities = [];
            for (var i = 0; i < json.length; i++) {
              cities.push({
                label: json[i].city_name,
                city_id: parseInt(json[i].id)
              });
            }
            response(cities);
          });
      },
      select: function(event, ui) {
        updateStreetList(ui.item.city_id);
        selectedCityID = ui.item.city_id;
      }
    });
    $citiesInput.on('focus', function() {
      $citiesInput.autocomplete('search', '');
    });

    // Edit page init streets list
    if (updateButton.length > 0) {
      if ($citiesInput.val()) {
        updateStreetList($citiesInput.attr('data-city-id'));
      }
    }

    // Add new record
    var $msgBlock = $('.phonebook-form__msg-block');
    $('.phonebook-form__submit').on('click', function() {
      if (!$phoneInput.val().match(/(\+7\s[0-9]+\s[0-9]+-[0-9]+-[0-9]+)/)) {
          $msgBlock
          .removeClass('red green')
          .text('Неправильно введен номер')
          .addClass('red');
      } else {
        $msgBlock.text('');
      }
        $msgBlock.text('');
      var data = $('.phonebook-form').serializeArray();
      data.push(
        {
          name: 'person_data[city_id]',
          value: selectedCityID
        }
      );

      $.ajax({
          url: 'db_create_user_data.php',
          method: 'post',
          data: data,
          dataType: 'json'
        })
        .done(function(json) {
          if (json) {
            var colorBlock = json.value == 0 ? 'red' : 'green';
              $msgBlock
              .removeClass('red green')
              .text(json.text).addClass(colorBlock);
            updateRecordsList();
          }
        });
      return false;
    });

    // Get user data for edit page
    if (window.location.href == 'edit.php') {
      $.ajax({
        url: 'db_get_user_data.php',
        method: 'post'
      })
    }
    // Update record
    updateButton.on('click', function() {
      if (!$phoneInput.val().match(/(\+7\s[0-9]+\s[0-9]+-[0-9]+-[0-9]+)/)) {
          $msgBlock
          .removeClass('red green')
          .text('Неправильно введен номер')
          .addClass('red');
      } else {
          $msgBlock.text('')
      }
        $msgBlock.text('');
        var data = $('.phonebook-form').serializeArray();
        data.push(
          {
            name: 'person_data[city_id]',
            value: $citiesInput.attr('data-city-id')
          });
      $.ajax({
        url: 'db_edit_user_data.php',
        method: 'post',
        data: data,
        dataType: 'json'
      }).done(function(json) {
        if (json) {
          var colorBlock = json.value == 0 ? 'red' : 'green';
            $msgBlock
            .removeClass('red green')
            .text(json.text).addClass(colorBlock);
        }
      });
      return false;
    });
  })
}(window.jQuery, window, document));
