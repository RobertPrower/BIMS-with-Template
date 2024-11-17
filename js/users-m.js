// To handle role-based access
const userRole = '<?php echo $userRole; ?>';

if (userRole === 'Secretariat') {
  document.querySelectorAll('.sidebar a').forEach(link => {
      if (link.href.includes('edit') || link.href.includes('delete')) {
      link.style.display = 'none';
    }
  });
} else if (userRole === 'User') {
  document.querySelectorAll('.sidebar a').forEach(link => {
    if (link.href.includes('settings') || link.href.includes('users') || link.href.includes('blotter-lupon')) {
      link.style.display = 'none';
    }
  });
} else if (userRole === 'Blotter/Lupon Dept.') {
  document.querySelectorAll('.sidebar a').forEach(link => {
    if (link.href.includes('documents') || link.href.includes('settings') || link.href.includes('users')) {
      link.style.display = 'none';
    }
  });
} else if (userRole === 'Clearance Dept.') {
  document.querySelectorAll('.sidebar a').forEach(link => {
    if (link.href.includes('documents') || link.href.includes('settings') || link.href.includes('users')) {
    link.style.display = 'none';
    }
  });
}