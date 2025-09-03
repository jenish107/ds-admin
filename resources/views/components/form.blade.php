@if (session('message'))
    <h2 class="text-success">{{ session('message') }}</h2>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form class="form-horizontal" action="{{ route($routeName) }}" method="POST">
                @csrf
                @if ($obj)
                    @method('PUT')
                @endif
                <div class="card-body">

                    <div class="form-group row mt-3">
                        <label for="name" class="col-md-3">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Name Here" value="{{ $obj->name ?? '' }}" />
                            @error('name')
                                <div>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-3">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $obj->email ?? '' }}" name="email"
                                id="email" placeholder="email " />
                            @error('email')
                                <div>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    @if ($parentId)
                        <input type="hidden" value="{{ $parentId ?? '' }}" name="parentId" />
                    @endif
                    <input type="hidden" value="{{ $obj->id ?? '' }}" name="id" />
                </div>
                <div class="border-top">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary">
                            @if ($obj)
                                Update
                            @else
                                Add
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
