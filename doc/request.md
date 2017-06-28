# Request

### url_is(url, Class Name)

方法一 `url_is("project*", "active")` 只要網址開頭是 project 都會給于 `"active"`

```
<li><a href="{{ url("project/index") }}" class="{{ url_is("project*", "active") }}">index</a></li>
```

方法二 `url_is("project/*", "active")` 只有網址是 project/ 下面的檔案才會給于 `"active"`

```
<li><a href="{{ url("project/index") }}" class="{{ url_is("project*", "active") }}">index</a></li>
```

方法三 `url_is("project/contact", "active")` 只有網址是 project/contact 才會給于 `"active"`

```
<li><a href="{{ url("project/contact") }}" class="{{ url_is("project/contact", "active") }}">contact</a></li>
```