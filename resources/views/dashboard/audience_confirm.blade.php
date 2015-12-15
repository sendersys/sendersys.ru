</div>
<div class="null_audience__separator"></div>
<div class="container">
<div class ="row">
    <div class="col-md-12 col-sm-12 ">
        <p class="confirm_desc">Для дальнейшей работы с сайтом необходимо подвердить домен. Для этого выполните один из шагов ниже</p>
        <ul>
            <li>
                <p><strong>Размещение HTML-файла в корневом каталоге сайта:</strong></p>
                <p>Создайте HTML-файл с именем sendersys_{{$confirm_hash}}.html и указанным ниже содержимым. Загрузите файл в корневой каталог вашего сайта.</p>
                <pre><code class="html"><span class="nt">&lt;<span class="title">html</span>&gt;</span>
    <span class="nt">&lt;<span class="title">head</span>&gt;</span>
      <span class="nt">&lt;<span class="title">meta</span> <span class="na">http-equiv</span>=<span class="s">"Content-Type"</span> <span class="na">content</span>=<span class="s">"text/html; charset=UTF-8"</span>&gt;</span>
    <span class="nt">&lt;/<span class="title">head</span>&gt;</span>
    <span class="nt">&lt;<span class="title">body</span>&gt;</span>Confirm: {{$confirm_hash}}<span class="nt">&lt;/<span class="title">body</span>&gt;</span>
<span class="nt">&lt;/<span class="title">html</span>&gt;</span></code></pre>
                </li>
            <li>
                <p><strong>Размещение мета-тега на главной странице сайта:</strong></p>
                <p>Добавьте в код главной страницы вашего сайта в раздел <span class="tag codeph">&lt;head&gt;</span> мета-тег:</p>
                <pre><code class="html"><span class="nt">&lt;meta</span> <span class="na">name=</span><span class="s">"sendersys-confirm"</span> <span class="na">content=</span><span class="s">"{{$confirm_hash}}"</span><span class="nt">&gt;</span></code></pre>
            </li>
        </ul>

        <p>После выполнения иструкций перейдите по ссылке <a href="/domen_confirm?confirm_id={{$domen_id}}">Обновить</a></p>
    </div>
</div>

