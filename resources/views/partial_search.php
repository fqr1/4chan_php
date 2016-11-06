<script id="entry-template" type="text/x-handlebars-template">
  <div class="entry">
    <h1>{{title}}</h1>
    <div class="body">
      {{body}}
    </div>
  </div>
</script>

<script id="data-template" type="text/x-handlebars-template">
<div style="margin-top: 50px;border-style: solid;border-color: gray;">
  <div style="display:inline-block;width:49%;vertical-align: top;">
    <div style="border-bottom: gray;border-bottom-style: dashed;">
      <p>thread: {{data.thread_id}}</p>
      <p>board: {{data.board}}</p>

      {{#if data.semantic_url}}
        <p style="color:red">semantic_url: {{data.semantic_url}}</p>
      {{/if}}

      {{#if data.url_data}}
        <p>downloaded: {{data.downloaded}}</p>
        <p>url data: {{data.url_data}}</p>
      {{/if}}

    </div>
    <div>{{{data.com}}}</div>
  </div>
  <div style="display:inline-block;width:49%">

    {{#if data.url_data }}
      {{#if (ifGreater data.downloaded 0) }}
        <img src="{{full_url data}}" style="width: 100%"></div>
      {{/if}}
    {{/if}}

</div>
</script>
