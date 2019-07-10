@extends('_layouts.template')
@section('title', 'index')
@section('content')
    <div class="pt-3">

        <button type="button" class="btn btn-secondary" data-toggle="snackbar" data-content="Free fried chicken here! <a href='https://example.org' class='btn btn-info'>Check it out</a>" data-html-allowed="true" data-timeout="0">
            Snackbar
        </button>

        <div class="media">
            <img class="mr-3" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2264%22%20height%3D%2264%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%2064%2064%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16bda83a366%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16bda83a366%22%3E%3Crect%20width%3D%2264%22%20height%3D%2264%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2213.546875%22%20y%3D%2236.5%22%3E64x64%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Generic placeholder image">
            <div class="media-body">
                <h5 class="mt-0">Media heading</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            </div>
        </div>
        <button type="button" class="btn btn-raised btn-primary">Primary</button>
        <button type="button" class="btn btn-raised btn-secondary">Secondary</button>
        <button type="button" class="btn btn-raised btn-success">Success</button>
        <button type="button" class="btn btn-raised btn-info">Info</button>
        <button type="button" class="btn btn-raised btn-warning">Warning</button>
        <button type="button" class="btn btn-raised btn-danger">Danger</button>
        <button type="button" class="btn btn-raised btn-link">Link</button>
        <button type="button" class="btn btn-raised active"><code>.active</code></button>

        <button type="button" class="btn btn-primary bmd-btn-fab">
            <i class="material-icons">grade</i>
        </button>
        <button type="button" class="btn btn-secondary bmd-btn-fab">
            <i class="material-icons">grade</i>
        </button>
        <button type="button" class="btn btn-success bmd-btn-fab">
            <i class="material-icons">grade</i>
        </button>
        <button type="button" class="btn btn-info bmd-btn-fab">
            <i class="material-icons">grade</i>
        </button>
        <button type="button" class="btn btn-warning bmd-btn-fab">
            <i class="material-icons">grade</i>
        </button>
        <button type="button" class="btn btn-danger bmd-btn-fab">
            <i class="material-icons">grade</i>
        </button>
        <button type="button" class="btn btn-danger bmd-btn-fab active">
            <i class="material-icons">grade</i>
        </button>

        <form>
            <div class="form-group">
                <label for="exampleInputEmail1" class="bmd-label-floating">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1">
                <span class="bmd-help">We'll never share your email with anyone else.</span>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1" class="bmd-label-floating">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label for="exampleSelect1" class="bmd-label-floating">Example select</label>
                <select class="form-control" id="exampleSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleSelect2" class="bmd-label-floating">Example multiple select</label>
                <select multiple class="form-control" id="exampleSelect2">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleTextarea" class="bmd-label-floating">Example textarea</label>
                <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputFile" class="bmd-label-floating">File input</label>
                <input type="file" class="form-control-file" id="exampleInputFile">
                <small class="text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                    Option one is this and that&mdash;be sure to include why it's great
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                    Option two can be something else and selecting it will deselect option one
                </label>
            </div>
            <div class="radio disabled">
                <label>
                    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled>
                    Option three is disabled
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Check me out
                </label>
            </div>
            <button class="btn btn-default">Cancel</button>
            <button type="submit" class="btn btn-primary btn-raised">Submit</button>
        </form>
    </div>
@endsection