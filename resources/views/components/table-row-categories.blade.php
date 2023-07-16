<tr>
    <td><p class="text-center">{{$name}}</p></td>
    <td><p class="text-center">{{$parent ?: '-'}}</p></td>
    <td><p class="text-center">{{$description ?: '-'}}</p></td>
    <td>
        <div class="d-flex justify-content-center align-items-center">
            <div>
                <a href="{{route('admin.categories.edit', ['category' => $slug])}}" class="text-warning">
                    <i class="fas fa-edit"></i>
                </a>
            </div>

            <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                <form action="{{route('admin.categories.destroy', ['category' => $slug])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn" data-delete-category>
                        <i class="fas fa-trash text-danger" data-delete-category="{{$name}}"></i>
                    </button>
                </form>
            </div>
        </div>
    </td>
</tr>

