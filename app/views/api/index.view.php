<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.4.0/styles/monokai.min.css" />
    <title>Api Documentation</title>

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            background-color: #fff;
        }

        h1 {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 0.5em;
            text-align: center;
        }

        .api {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            width: 100%;
            margin: 0 auto;
        }

        .api__endpoints {
            width: 40%;
            min-width: 300px;
        }

        .api__visualiser {
            width: 60%;
            min-width: 500px;
        }

        .endpoints__title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .endpoints__list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .endpoints__item {
            margin-bottom: 1rem;
        }

        .endpoints__button {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            cursor: pointer;
        }

        .endpoints__link {
            font-style: italic;
            color: teal;
        }

        .endpoints__desc {
            font-style: italic;
        }

        .endpoints__method {
            font-size: 1.5rem;
            font-weight: bold;
            color: green;
        }

        .temp {
            text-align: center;
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media screen and (max-width: 870px) {
            .api{
                flex-direction: column;
            }
            .api__endpoints {
                width: 100%;
                min-width: 0;
            }

            .api__visualiser {
                width: 100%;
                min-width: 0;
            }
        }
    </style>
</head>

<body>
    <h1>Api Documentation</h1>
    <div class="api">
        <div class="api__endpoints">
            <h2 class="endpoints__title">API endpoints</h2>
            <ul class="endpoints__list">
                <li class="endpoints__item">
                    <button class="endpoints__button" onclick="getAllPosts()">
                        <span class="endpoints__method endpoints__method--get">GET</span>
                        <span class="endpoints__link">/api/posts</span>
                        <span class="endpoints__desc">Get all posts</span>
                    </button>
                </li>
                <li class="endpoints__item">
                    <button class="endpoints__button" onclick="getPostById()">
                        <span class="endpoints__method endpoints__method--get">GET</span>
                        <span class="endpoints__link">/api/post</span>
                        <span class="endpoints__desc">Get a specific post with id of:</span>
                    </button>
                    <input class="endpoints__input" type="number" id="postId" value="4" required>
                </li>
                <li class="endpoints__item">
                    <button class="endpoints__button" onclick="getPostsByCategoryId()">
                        <span class="endpoints__method endpoints__method--get">GET</span>
                        <span class="endpoints__link">/api/posts/category</span>
                    </button>
                </li>
                <li class="endpoints__item">
                    <button class="endpoints__button" onclick="getPostsByUserId()">
                        <span class="endpoints__method endpoints__method--get">GET</span>
                        <span class="endpoints__link">/api/posts/user</span>
                    </button>
                </li>
                <li class="endpoints__item">
                    <button class="endpoints__button" onclick="getPostsByCategory()">
                        <span class="endpoints__method endpoints__method--get">GET</span>
                        <span class="endpoints__link">/api/posts/category</span>
                    </button>
                </li>
                <li class="endpoints__item">
                    <button class="endpoints__button" onclick="getPostsByUser()">
                        <span class="endpoints__method endpoints__method--get">GET</span>
                        <span class="endpoints__link">/api/posts/user</span>
                    </button>
                </li>
            </ul>
        </div>
        <div class="api__visualiser">
            <h2 class="endpoints__title">Response Visualiser</h2>
            <pre><code class="json"><div class="temp">Response will be shown here in JSON format</div></code></pre>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.4.0/highlight.min.js"></script>
    <script>
        /*function getAllPosts() {
          console.log(document.querySelector("code"));
          var xhr = new XMLHttpRequest();
          xhr.open("GET", "/api/posts", true);
          xhr.onload = function () {
            if (this.status == 200) {
              var response = JSON.parse(this.responseText);
              console.log(document.querySelector("code"), response);
              document.querySelector("code").innerText = JSON.stringify(
                  response,
                  null,
                  4
                  );
                  hljs.highlightElement(document.querySelector("code"));
              }
          };
          xhr.send();
        }*/

        // get all posts with Fetch API
        function getAllPosts() {
            fetch("/api/posts")
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    console.log(data);
                    document.querySelector("code").innerHTML = JSON.stringify(
                        data,
                        null,
                        4
                    );
                    hljs.highlightElement(document.querySelector("code"));
                });
        }
    </script>
</body>

</html>