# Request

### is(url, Class Name)

* `is("project*", "active")` 只要網址開頭是 `project` 都會給于 `"active"`
```php
<li><a href="{{ url("project/index") }}" class="{{ is("project*", "active") }}">index</a></li>
```
* `is("project/*", "active")` 只有網址是 `project/` 下面的檔案才會給于 `"active"`
```php
<li><a href="{{ url("project/index") }}" class="{{ is("project*", "active") }}">index</a></li>
```
* `is("project/contact", "active")` 只有網址是 `project/contact` 才會給于 `"active"`
```php
<li><a href="{{ url("project/contact") }}" class="{{ is("project/contact", "active") }}">contact</a></li>
```