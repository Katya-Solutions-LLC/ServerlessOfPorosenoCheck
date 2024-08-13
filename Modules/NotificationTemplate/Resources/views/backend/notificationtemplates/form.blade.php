<div class="row">
  <div class="col-md-4">
      <div class="row">
          {{ Form::hidden('id',null) }}
          <div class="col-md-12">
              <div class="form-group">
                  <label>{{ (__('Type')) }} : <span class="text-danger">*</span></label>
                  <select name="type" class="form-control select2" id="type" onchange="onChangeType()" data-ajax--url="{{ route('backend.notificationtemplates.ajax-list',['type' => 'constants_key','data_type' => 'notification_type']) }}" data-ajax--cache="true" required>
                      @if(isset($data->type))
                        <option value="{{ $data->type }}" selected>{{ $data->constant->name ?? '' }}</option>
                      @endif
                  </select>
              </div>
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label>{{ (__('Parameters')) }} :</label><br>
                  <div class="main_form">
                      @if(isset($buttonTypes))
                        @include('notificationtemplate::backend.notificationtemplates.perameters-buttons',['buttonTypes' => $buttonTypes])
                      @endif
                  </div>
              </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
            <div class="d-flex justify-content-between align-items-center">
              <label class="form-label" for="category-status">{{ __('messages.status') }} :</label>
              <div class="form-check form-switch">
                <input class="form-check-input" value="1" name="status" id="category-status" type="checkbox" v-model="status" />
              </div>
            </div>
          </div>
        </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label>{{ (__('To')) }} :</label><br>
                  <select name="to[]" class="form-control select2" data-ajax--url="{{ route('backend.notificationtemplates.ajax-list',['type' => 'constants_key','data_type' => 'notification_to']) }}" data-ajax--cache="true" multiple>
                      @if(isset($data))
                      @if($data->to != null)
                      @foreach(json_decode($data->to) as $to)
                      <option value="{{$to}}" selected="">{{$to}}</option>
                      @endforeach
                      @endif
                      @endif
                  </select>
              </div>
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label>{{ (__('BCC')) }} :</label><br>
                  <select class="form-control select2-tag" name="bcc[]" multiple="">
                      @if(isset($data))
                      @if($data->bcc != null)
                      @foreach(json_decode($data->bcc) as $bcc)
                      <option value="{{$bcc}}" selected="">{{$bcc}}</option>
                      @endforeach
                      @endif
                      @endif
                  </select>
              </div>
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label>{{ (__('CC')) }} :</label><br>
                  <select class="form-control select2-tag" name="cc[]" multiple="">
                      @if(isset($data))
                      @if($data->cc != null)
                      @foreach(json_decode($data->cc) as $cc)
                      <option value="{{$cc}}" selected="">{{$cc}}</option>
                      @endforeach
                      @endif
                      @endif
                  </select>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-8 ">
      <div class="row pl-3">
          <div class="col-md-12">
              <div class="form-group">
                  <label class="float-left">{{ (__('messages.subject')) }} :</label>
                  {{ Form::text("defaultNotificationTemplateMap[subject]",null,['class' => 'form-control']) }}

                  {{ Form::hidden("defaultNotificationTemplateMap[status]",1,['class' => 'form-control']) }}
              </div>

              <div class="text-left">
                  <label>{{ (__('messages.template')) }} :</label>
                  {{ Form::hidden("defaultNotificationTemplateMap[language]",'en') }}
              </div>
              <div class="form-group">
                  {{ Form::textarea("defaultNotificationTemplateMap[template_detail]",null,['class' => 'form-control textarea','id' => "mytextarea"]) }}
              </div>
              <div class="form-group">
                  <label class="float-left">{{ (__('messages.notification_body')) }} :</label>
                  {{ Form::text("defaultNotificationTemplateMap[notification_message]",null,['class' => 'form-control notification_message','id' => "en-notification_message"]) }}
              </div>
              <div class="form-group">
                  <label class="float-left">{{ (__('messages.notification_link')) }} :</label>
                  {{ Form::text("defaultNotificationTemplateMap[notification_link]",null,['class' => 'form-control notification_link','id' => "en-notification_link"]) }}
              </div>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12 pt-2">
          <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> {{ (__('save'))}}<i class="md md-lock-open"></i></button>
          <button onclick="window.history.back();"  class="btn btn-outline-primary" ><i class="fa-solid fa-angles-left"></i> {{ (__('close'))}}<i class="md md-lock-open"></i></button>
      </div>
  </div>
</div>
<script>
  function onChangeType(url, render) {
      var dropdown = document.getElementById("type");
      var selectedValue = dropdown.value;
      var url = "{{ route('backend.notificationtemplates.notification-buttons',['type' => 'buttonTypes']) }}";
      $.get(url, function(data) {
          var html = data;
          if (render !== undefined && render !== '' && render !== null) {
              $('.' + render).html(html);
          } else {
              $(".main_form").html(html);
              $("#formModal").modal("show");
          }
      });
  }
</script>
