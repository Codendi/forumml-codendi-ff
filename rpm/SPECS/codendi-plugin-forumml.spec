Summary: ForumML plugin for Codendi
Name: codendi-plugin-forumml
Version: 1.0
Release: 0
License: GPL
Group: Development/Languages
URL: https://github.com/Codendi/forumml-codendi-ff/

Packager: Nicolas Terray <nicolas.terray@xrce.xerox.com>

Source: %{name}.tgz
BuildRoot: %{_tmppath}/%{name}-%{version}-%{release}-root

BuildArch: noarch

%description
ForumML plugin for Codendi
ForumML is a contraction of "Forum - Mailing List".
The goal of the plugin is to add forum-like behaviors to mailing lists.

ForumML is a plugin that adds a web interface to mailing list archives.
It makes it easier to browse and search mailing lists.
It also provides a way to post to a list from the web interface.
In this case, Codendi uses your login email adress to post to the list.
The actual acceptance/distribution/archival of the message still 
depends on mailman configuration.

%prep
%setup -n %{name}  
%build

%install
%{__rm} -rf %{buildroot}
%{__mkdir} -p %{buildroot}/%{_datadir}/codendi/plugins/forumml
%{__cp} -ar . %{buildroot}/%{_datadir}/codendi/plugins/forumml

%clean
%{__rm} -rf %{buildroot}

%files
%defattr(-, codendiadm, codendiadm, 0755)
%{_datadir}/codendi/plugins/forumml

%changelog
* Tue May 11 2010 Nicolas TERRAY <nicolas.terray@xrce.xerox.com> - 1.0
- Initial package
