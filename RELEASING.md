# Releasing a New Version

For project maintainers.

The project currently uses three long-lived branches:

* `main` for releases in the active `4.x` line.
* `develop` for ongoing `4.x` development between releases.
* `support/3` for long-term support releases in the `3.x` line.

1. Before committing to a release...
    1. [Check the issue queue](https://github.com/acquia/orca/issues) for critical issues.
    1. Search the codebase for important `@todo` comments.
1. Create a release tag for the line you are releasing:
    1. Make sure your local long-lived branches are current with upstream.
    1. Choose a [semantic version](https://semver.org/) number (`x.y.z`).
    1. For a `4.x` release, start the release from `develop` with [Gitflow](https://github.com/nvie/gitflow) using `git flow release start x.y.z`.
    1. For a `4.x` release, finish it with `git flow release finish x.y.z`, which updates `main` and `develop`.
    1. For a `3.x` maintenance release, create the release tag directly from `support/3` and push the updated `support/3` branch.
    1. Push the release tag to GitHub along with the updated long-lived branch or branches for that release line.
1. If a fix applies to multiple supported lines, backport or forward-port it between `support/3`, `develop`, and `main` as appropriate before releasing.
1. [Create a GitHub release.](https://help.github.com/articles/creating-releases/)
    1. Set the tag version and release title both to the new version number.
    1. Use the changelog for the description.
