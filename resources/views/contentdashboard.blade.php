<div>
    <h1>this is a list of content</h1>
    <table border="1">
        <thead>
            <tr>
                <th>text</th>
                <th>url</th>
                <th>Img_dir</th>
                <th>Operation</th>
                <th>Modify</th>
                <th>Modify</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contents as $content)
            <tr>
            <td>{{ $content->text }}</td>
            <td>{{ $content->url}}</td>
            <td>{{ $content->img_dir }}</td>
            <td>
                <a href={{ "deletecontent/".$content['id'] }}>Delete</a>
            </td>
            <td>
                <a href={{ "writecomment/".$content['id'] }}>Update</a>
            </td>
            <td>
                <a href={{ "like/".$content['id'] }}>Update</a>
            </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <span>
        {{ $contents->links() }}
    </span>

    <a href={{ "/content/newContent" }}>addContent</a>
</div>

<style> 
.w-5{ 
display: none 
} 
</style> 