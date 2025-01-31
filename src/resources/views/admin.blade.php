@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
  @section('content')
  <main>
    <div class="admin__content">
        <div class="admin__heading">
            <h2>Admin</h2>
        </div>
        <form class="" action="/admin/search" method="get">
            <div class="">
                <input type="text" name="query" placeholder="名前やメールアドレスを入力してください" value="{{ request('query') }}">
            </div>
            <div class="">
                <select class="form-control" name="gender">
                    <option value="">性別</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>男性</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>女性</option>
                    <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>その他</option>
                </select>
            </div>
            <div class="">
                <select class="form-control" name="inquiry_type">
                    <option value="">お問い合わせの種類を選択</option>
                    <option value="question" {{ request('inquiry_type') == 'question' ? 'selected' : '' }}>商品の交換について</option>
                    <option value="feedback" {{ request('inquiry_type') == 'feedback' ? 'selected' : '' }}>商品の使用方法について</option>
                    <option value="other" {{ request('inquiry_type') == 'other' ? 'selected' : '' }}>その他</option>
                </select>
            </div>
            <div>
                <button type="submit" class="" >検索</button>
            </div>
        </form>


        <table>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
            @foreach($contacts as $contact)
            <tr>
                <td>{{$contact->name}}</td>
                <td>{{$contact->gender}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->inquiry_type}}</td>
                <td>
                    <button class="button-info" data-bs-toggle="modal" data-bs-target="#detailsModal" onclick="showDetails({{$contact->id}})">詳細</button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- モーダルウィンドウ -->
     <div class="modal fade" id="detailsModal" tabindex="1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="modalDetailsBody">
                    <p>読み込み中</p>
               </div>

                <div class="model-footer">
                    <form id="deleteform" method="post" action="/admin/delete/{{$contact->id}}"  >
                        @csrf
                        <button type="submit" class="" >削除</button>
                    </form>
                </div>
            </div>
        </div>
     </div>

    
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function showDetails(id) {
        fetch(`/admin/details/${id}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const modalBody = document.getElementById('modalDetailsBody');
                const deleteForm = document.getElementById('deleteform');
                if (data.success) {
                    let html = `
                        <table>
                            <tr>
                                <th>お名前</th>
                                <td>${data.details.name}</td>
                            </tr>
                            <tr>
                                <th>性別</th>
                                <td>${data.details.gender}</td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td>${data.details.email}</td>
                            </tr>
                            <tr>
                                <th>電話番号</th>
                                <td>${data.details.tel}</td>
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td>${data.details.address}</td>
                            </tr>
                            <tr>
                                <th>建物名</th>
                                <td>${data.details.building}</td>
                            </tr>
                            <tr>
                                <th>お問い合わせの種類</th>
                                <td>${data.details.inquiry_type}</td>
                            </tr>
                            <tr>
                                <th>お問い合わせ内容</th>
                                <td>${data.details.content}</td>
                            </tr>
                        </table>
                    `;
                    modalBody.innerHTML = html;
                    deleteForm.action = `/admin/delete/${data.details.id}`;
                } else {
                    modalBody.innerHTML = '<p>詳細データはありません。</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('modalDetailsBody').innerHTML = '<p>エラーが発生しました。</p>';
            });
    }
    </script>
    @endsection
